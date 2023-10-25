#!/usr/bin/perl --

# -----------------------
# fmailフォルダ以下に英数字以外のファイル名があると途中でとまります。
# -----------------------

print "Pragma: no-cache\n";
print "Cache-Control: no-cache\n";
print "Content-type: text/html; charset=UTF-8\n\n";
print "<html><head><title>install fmail</title></head><body style=\"background-color: #000000;\">";

@cgi = ('fmail.postcode.cgi','fmail.formlog.cgi','index.cgi','download.cgi','download_cart.cgi','zip.php','cart.lib.cgi');
@cdir = ('./fmail.admin','./fmail.admin/datas');

$cnt = 0;
$error = 0;
my @dirs = ('./');
while($cnt < @dirs){
	$dir = $dirs[$cnt];
	opendir DH, $dir or die "$dir:$!";
	while (my $file = readdir DH) {
		next if $file =~ /^\.{1,2}$/;
		$checkdir = $dir . $file;
# 日本語ファイルを探したい場合にコメントアウトを外す
#		print "<font color=\"#009900\">${checkdir}</font><br />";
		my(@type) = split(/\./,$checkdir);
		if(-d $checkdir){
			push @dirs, "${checkdir}/";
			if($checkdir eq './fmail.admin'){
				$ch = chmod 0755, $checkdir;
				if($ch){
					print "<font color=\"#009900\">${checkdir} \[ SUCCESS \]</font><br />";
				}
				else {
					print "<font color=\"red\">${checkdir} \[ ERROR \]</font><br />";
					$error++;
				}
			}
			elsif(index($checkdir,'/datas') > -1){
				$ch = chmod 0777, $checkdir;
				if($ch){
					print "<font color=\"#009900\">${checkdir} \[ SUCCESS \]</font><br />";
				}
				else {
					print "<font color=\"red\">${checkdir} \[ ERROR \]</font><br />";
					$error++;
				}
			}
		}
		if(1 == grep(/^${file}$/,@cgi)){
			$ch = chmod 0755, $checkdir;
			if($ch){
				print "<font color=\"#009900\">${checkdir} \[ SUCCESS \]</font><br />";
			}
			else {
				print "<font color=\"red\">${checkdir} \[ ERROR \]</font><br />";
				$error++;
			}
		}
		elsif(index($checkdir,'/datas/') > -1){
			$ch = chmod 0777, $checkdir;
			if($ch){
				print "<font color=\"#009900\">${checkdir} \[ SUCCESS \]</font><br />";
			}
			else {
				print "<font color=\"red\">${checkdir} \[ ERROR \]</font><br />";
				$error++;
			}
		}
	}
	closedir DH;
	$cnt++;
}
if($error < 1){
	print "<h2 style=\"color: #FFFFFF;\">PROCESSING COMPLETION</h2>";
	print '<script type="text/javascript">location.href = "./fmail.admin/index.cgi";</script>';
	print "</body></html>";
}
else {
	print "<h2 style=\"color: #FF0000;\">${error} FILE ERROR</h2></body></html>";
}
unlink './installFmail.cgi';
exit;