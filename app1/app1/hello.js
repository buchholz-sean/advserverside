// var http = require( "http" );

express = require( 'express' );
var app = express();

app.get( "/", function( req,res ){
    res.end( "Hello world" );
} )

// var server = http.createServer( function( req,res ){
//
//     res.writeHead( 200,{ "Content-Type":"text/plain" } );
//
//     res.end( "Hello World" );
//
// } );
//
// server.listen( 8000 );

app.listen(8000, function(){
    console.log( "Server running, listening on port 8000" );
});