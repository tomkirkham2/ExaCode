#!/usr/bin/perl --
print "Content-Type: text/event-stream\n\n";
while(true){
  print "event: server-time\n";
  $num++;
  print "data: $num\n\n";
}
