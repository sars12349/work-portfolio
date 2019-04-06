const http = require('http');

const server = http.createServer((req, res) => {
    if (req.url ==='/') {
        res.write('Hello World');
        res.end();
    }

    if(req.url === '/api/courses') {
        res.write(JSON.stringify([1, 2, 3]));
        res.end();
    }
});

// server.on('connection', (socket) => {
//     console.log('New connection...');
// });

server.listen(3000);

console.log('Listening on port 3000...');








// event

// const EventEmitter= require('events');
// // const emitter = new EventEmitter();

// const Logger = require('./logger');
// const logger=new Logger();

// // Register a listener
// logger.on('messageLogged', (arg) => {
//     console.log('Listener called',arg);
// });

// logger.log('message');
// // Raise: logging (data:message)





// fs

// const fs = require('fs');

// // const files = fs.readdirSync('./');
// // console.log(files);

// fs.readdir('./', function(err, files) {
//     if (err) console.log('Error', err);
//     else console.log('Result', files);
// });



// os
// var totalMemory = os.totalmem();
// var freeMemory=os.freemem();


// console.log(`Total Memory: ${totalMemory}`);
// console.log(`Free Memory: ${freeMemory}`);