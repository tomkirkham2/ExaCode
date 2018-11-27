#!/usr/bin/perl




use strict;
use DBI;





$|=1;

open(EXEC, '-|',
    'sudo', 'ifconfig', 'wlan0', 'down')
    or die "Can't exec: $!\n";


open(EXEC, '-|',
    'sudo', 'iwconfig', 'wlan0', 'mode', 'monitor')
    or die "Can't exec: $!\n";

open(EXEC, '-|',
    'sudo', 'ifconfig', 'wlan0', 'up')
    or die "Can't exec: $!\n";




