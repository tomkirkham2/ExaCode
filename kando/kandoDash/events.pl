#!/usr/bin/env perl
use Mojolicious::Lite;

get '/' => 'index';

get '/events' => sub {
  my $self = shift;

  # Emit "dice" event every second
  $self->res->headers->content_type('text/event-stream');
  my $id = Mojo::IOLoop->recurring(1 => sub {
    my $pips = int(rand 6) + 1;
    $self->write("event:dice\ndata: $pips\n\n");
  });
  $self->on(finish => sub { Mojo::IOLoop->remove($id) });
};

app->start;

