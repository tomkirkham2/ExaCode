#!/usr/bin/perl

print "Content-Type: text/event-stream\n\n";

while(true){
   print "Event: server-time\n";
   $time = localtime();
   print "Data: $time\n";
   sleep(5);
}
