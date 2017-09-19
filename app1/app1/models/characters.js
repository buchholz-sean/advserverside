var db = require('../db');

// Set unique index on `name` field
exports.indexNames = function() {
    var collection = db.get().collection('characters');
    collection.createIndex({
        name: 1
    }, {
        unique: true
    });
}

// CREATE
exports.save = function(query) {
    var collection = db.get().collection('characters');
    collection.save(query, function(err, result) {
        if (err) throw err;
        console.log('character saved');
    });
}

// READ
exports.all = function(callback) {
    var collection = db.get().collection('characters');
    collection.find().toArray(function(err, result) {
        callback(err, result);
    })
}

exports.getCharByName = function(query, callback) {
    var collection = db.get().collection('characters');
    collection.find({
        name: query
    }).toArray(function(err, result) {
        callback(err, result);
    })
}

// UPDATE
exports.update = function(query, update) {
    var collection = db.get().collection('characters');
    collection.update(query, update, function(err, result) {
        if (err) throw err;
        console.log(query.name + ' updated');
    })
}

// DELETE
exports.delete = function(query) {
    var collection = db.get().collection('characters');
    collection.deleteOne({
        name: query
    }, function(err, result) {
        if (err) return err;
        console.log(query + ' deleted');
    });
}
