var server = require('http').Server();
var io = require('socket.io')(server);
var env = require('node-env-file');
var request = require('request');

var IoRedis = require('ioredis');
var ioRedis = new IoRedis();
var redis = new IoRedis();

env(__dirname + '/.env');

ioRedis.subscribe('events');


function handleCreate(type, data) {
    switch (type) {
        case 'account':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_account', data);
            break;
        case 'email':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_email', data);
            break;
        case 'phone':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_phone', data);
            break;
        case 'duty':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_duty', data);
            break;
        case 'campus':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_campus', data);
            break;
        case 'building':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_building', data);
            break;
        case 'room':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_room', data);
            break;
        case 'department':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_department', data);
            break;
        case 'course':
            console.log('Emitting create : "' + type + '" event...');
            io.emit('create_course', data);
            break;
        default:
            console.log('Received an unknown create type: "' + type + '"');
    }
}

function handleDelete(type, data) {
    switch (type) {
        case 'account':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_account', data);
            break;
        case 'email':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_email', data);
            break;
        case 'phone':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_phone', data);
            break;
        case 'duty':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_duty', data);
            break;
        case 'campus':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_campus', data);
            break;
        case 'building':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_building', data);
            break;
        case 'room':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_building', data);
            break;
        case 'department':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_department', data);
            break;
        case 'course':
            console.log('Emitting delete : "' + type + '" event...');
            io.emit('delete_course', data);
            break;
        default:
            console.log('Received an unknown delete type: "' + type + '"');
    }
}

function handleRestore(type, data) {
    switch (type) {
        case 'account':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_account', data);
            break;
        case 'duty':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_duty', data);
            break;
        case 'campus':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_campus', data);
            break;
        case 'building':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_building', data);
            break;
        case 'room':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_room', data);
            break;
        case 'department':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_department', data);
            break;
        case 'course':
            console.log('Emitting restore : "' + type + '" event...');
            io.emit('restore_course', data);
            break;
        default:
            console.log('Received an unknown restore type: "' + type + '"');
    }
}

function handleAssignment(type, to, data) {
    switch (type) {
        case 'duty':
            if (to === 'account') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('duty_account_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'campus':
            if (to === 'building') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('campus_building_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'building':
            if (to === 'room') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('building_room_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'room':
            if (to === 'account') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('room_account_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'department':
            if (to === 'account') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('department_account_assignment', data);
            } else if (to === 'course') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('department_course_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'course':
            if (to === 'account') {
                console.log('Emitting ' + type + ' assignment event to ' + to + '...');
                io.emit('course_account_assignment', data);
            } else {
                console.log('Received an unknown assignment subject: "' + to + '" no emission occurred.');
            }
            break;
        default:
            console.log('Received an unknown assignment type: "' + type + '"');
    }
}

function handleUnassignment(type, to, data) {
    switch (type) {
        case 'duty':
            if (to === 'account') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('duty_account_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'campus':
            if (to === 'building') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('campus_building_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'building':
            if (to === 'room') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('building_room_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'room':
            if (to === 'account') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('room_account_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'department':
            if (to === 'account') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('department_account_unassignment', data);
            } else if (to === 'course') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('department_course_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        case 'course':
            if (to === 'account') {
                console.log('Emitting ' + type + ' unassignment event to ' + to + '...');
                io.emit('course_account_unassignment', data);
            } else {
                console.log('Received an unknown unassignment subject: "' + to + '" no emission occurred.');
            }
            break;
        default:
            console.log('Received an unknown unassignment type: "' + type + '"');
    }
}

function handleEvent(message) {
    message = JSON.parse(message);
    var event = message.event;
    var type = message.type;
    var data = message.encrypted;
    switch (event) {
        case 'created':
            handleCreate(type, data);
            break;
        case 'deleted':
            handleDelete(type, data);
            break;
        case 'restored':
            handleRestore(type, data);
            break;
        case 'assigned':
            handleAssignment(type, message.to, data);
            break;
        case 'unassigned':
            handleUnassignment(type, message.to, data);
            break;
        default:
            console.log('Received an unknown event: "' + event + '"');
    }
}


/**
 * Messages from Redis server
 */
ioRedis.on('message', function (channel, message) {
        switch (channel) {
            case 'events':
                handleEvent(message);
                break;
            default:
                console.log('Received request on unknown channel: "' + channel + '"');
        }
    }
);

/**
 * Messages from clients
 */
io.on('connection', function (socket) {

    socket.on('join', function (message) {
        var hostname = message.hostname;
        var socket_id = socket.id;
        redis.set(hostname, JSON.stringify({
            'socket': socket_id
        }));
        redis.set(socket_id, JSON.stringify({
            'hostname': hostname
        }));
        console.log(hostname + ' has connected with socket: ' + socket_id);
    });

    socket.on('disconnect', function () {
        var socket_id = socket.id;
        // Get the host by the socket ID
        redis.get(socket_id, function (err, result) {
            var host = JSON.parse(result);
            var hostname = host.hostname;
            // Delete the entry with that socket ID as the key
            redis.del(socket_id);
            redis.del(hostname);
            console.log(hostname + ' has disconnected');
        });
    });
});

server.listen(3000);
