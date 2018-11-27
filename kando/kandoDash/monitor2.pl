#!/usr/bin/perl
use strict;
use DBI;





$|=1;

open(EXEC, '-|', 
    'sudo', 'tcpdump', '-i','wlan0', '-e', '-s', '256', 'type', 'mgt', 'subtype', 'probe-req', 
'-l') 
    or die "Can't exec: $!\n";
 
#system('tcpdump -i wlan0 -j host -e -s 256 type mgt subtype probe-req' 
#) 
    #or die "Can't exec: $!\n";

my $t = (time() + 3600);
print $t;

# Now read the output just like a file
while(my $line = <EXEC>) {
    chomp $line;
  my $char = 'SA:';

my $result = index($line, $char);
$result = $result +3;
my $epoc = time();
my $second_char = substr($line, $result, "17");
print "mac: $second_char\n";
print "epoc: $epoc\n";

my $dbh = DBI->connect(          
    "dbi:mysql:dbname=Hannover", 
    "root",
    "huthwaite",
    { RaiseError => 1}
) or die $DBI::errstr;

if ($epoc = $t){
$dbh->do("TRUNCATE table macs");
$dbh->disconnect();
}
else{
$dbh->do("INSERT INTO macs VALUES('','$epoc','$second_char','20')");
#sleep 1;
$dbh->disconnect();
}





}
close(EXEC);

