var express = require('express');
var router = express.Router();

var Characters = require('../models/characters');

// General rendering options including page title and navigation items
var options = {
    title: 'Characters',
    navitems: [{
        link: '/',
        content: 'Home'
    }, {
        link: '/characters',
        content: 'Characters'
    }],
    classOpts: [{
            value: 'Bard',
            text: 'Bard'
        },
        {
            value: 'Barbarian',
            text: 'Barbarian'
        },
        {
            value: 'Cleric',
            text: 'Cleric'
        },
        {
            value: 'Druid',
            text: 'Druid'
        },
        {
            value: 'Fighter',
            text: 'Fighter'
        },
        {
            value: 'Immolator',
            text: 'Immolator'
        },
        {
            value: 'Paladin',
            text: 'Paladin'
        },
        {
            value: 'Ranger',
            text: 'Ranger'
        },
        {
            value: 'Thief',
            text: 'Thief'
        },
        {
            value: 'Wizard',
            text: 'Wizard'
        }
    ]
};


// GET Character List
router.get('/', function(req, res, next) {
    options.charsList = [];
    // Ensure unique index on names
    Characters.indexNames();
    // Get all characters in database and send to template
    Characters.all(function(err, results) {
        if (err) console.log(err);
        options.charsList = results;
        res.render('charsList', options);
    })
});

// GET Character Creation form
router.get('/create', function(req, res, next) {
    // Make sure no leftover messages
    res.render('createChar', options);
})

// POST Character Creation form data
router.post('/create', function(req, res, next) {
    // Initialize a blank user object
    var newChar = {
        name: '',
        class: '',
    };
    // Get values of input fields
    var nameInput = req.body.charName;
    var classInput = req.body.charClass;
    // Ensure all fields are filled out
    if (nameInput.trim() == '') {
        // Should never happen with HTML5 `required` parameter
        options.errmsg = 'Sorry, Name cannot be blank!';
        res.redirect('/characters/create');
    } else {
        var exists = function(query) {
            for (var i = 0; i < options.charsList.length; i++) {
                if (options.charsList[i].name == query)
                    return true;
            }
        }
        if (exists(nameInput)) {
            options.errmsg = 'Sorry, that character already exists!';
            res.redirect('/characters/create');
        } else {
            // Create new character using input values
            newChar.name = nameInput;
            newChar.class = classInput;
            // Save character to database
            Characters.save(newChar);
            // Redirect to character list
            options.charsList = [];
            res.redirect('/characters/success/' + newChar.name);
        }
    }
})

router.get('/success/:name', function(req, res, next) {
    options.newChar = req.params.name;
    res.render('success', options);
})

// GET Edit Character form
router.get('/edit/:name', function(req, res, next) {
    // Get character from db selected by name param in url
    Characters.getCharByName(req.params.name, function(err, result) {
        if (err) throw err;
        // Send that character to template
        options.charToEdit = result[0];
        res.render('edit', options);
    });
})

// POST Edit Character form data
router.post('/edit/:name', function(req, res, next) {
    var newChar = {
        name: '',
        class: ''
    };
    var nameInput = req.body.charName;
    var classInput = req.body.charClass;
    if (nameInput.trim() == '') {
        options.errmsg = 'Sorry, Name cannot be blank!';
        res.redirect('/characters/edit/' + options.charToEdit.name);
    } else {
        var idToCheck = '';
        var exists = function(query) {
            for (var i = 0; i < options.charsList.length; i++) {
                if (options.charsList[i].name == query) {
                    idToCheck = options.charsList[i]._id;
                    return true;
                }
            }
        }
        if (exists(nameInput)) {
            if (idToCheck.toString() != options.charToEdit._id.toString()) {
                options.errmsg = 'Sorry, that character already exists!';
                res.redirect('/characters/edit/' + options.charToEdit.name);
            } else {
                newChar.name = nameInput;
                newChar.class = classInput;
                Characters.update(options.charToEdit, newChar, function(err, result) {
                    if (err) throw err;
                    options.charsList = [];
                })
                res.redirect('/characters');
            }
        } else {
            newChar.name = nameInput;
            newChar.class = classInput;
            Characters.update(options.charToEdit, newChar, function(err, result) {
                if (err) throw err;
                options.charsList = [];
            })
            res.redirect('/characters');
        }
    }
})

// Delete Character
router.get('/delete/:name', function(req, res, next) {
    Characters.delete(req.params.name);
    options.charsList = [];
    res.redirect('/characters');
})


module.exports = router;
