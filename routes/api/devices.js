var express = require('express');
var path = require('path');
var db = require('../../db');
var auth = require('../auth');
var { v4: uuidv4 } = require('uuid');

var router = express.Router();

router.get('/list-devices', auth.middleware, (req, res, next) => {
    db.all('SELECT id, name, info FROM devices WHERE owner = ?', [ req.user.id ], (err, rows) => {
        if(err) {
            return res.status(500).send(JSON.stringify({
                status: 'error',
                message: 'Unknown internal error.'
            }));
        }

        return res.send(JSON.stringify({
            status:'ok',
            data: rows
        }));
    });
});

router.get('/get-device', auth.middleware, (req, res, next) => {
    if(req.body.id !== undefined && req.body.id != "") {
        db.get('SELECT * FROM devices WHERE owner = ? AND id = ?', [ req.user.id, req.body.id ], (err, row) => {
            if(err) {
                return res.status(500).send(JSON.stringify({
                    status: 'error',
                    message: 'Unknown internal error.'
                }));
            }
    
            if(row) {
                return res.send(JSON.stringify({
                    status: 'ok',
                    data: row
                }));
            }
    
            return res.send(JSON.stringify({
                status: 'error',
                message: 'Device not found.'
            }));
        });
    }

    return res.status(400).send(JSON.stringify({
        status: 'error',
        message: 'Invalid parameters.'
    }));
});

router.post('/add-device', auth.middleware, (req, res, next) => {
    if(req.body.name !== undefined && req.body.sensors !== undefined) {
        req.body.name = req.body.name.trim();
        let json = "";
        
        try {
            json = JSON.parse(req.body.sensors);
        } catch(e) {}

        if(req.body.name !== "" && Array.isArray(json)) {
            if(json.length == 0) {
                return res.status(400).send(JSON.stringify({
                    status: 'error',
                    message: 'Device must have at least one sensor set.'
                }));
            }

            return next();
        }
    }

    return res.status(400).send(JSON.stringify({
        status: 'error',
        message: 'Invalid parameters.'
    }));
}, (req, res) => {
    db.all('SELECT id FROM devices WHERE owner = ? AND name = ?', [ req.user.id, req.body.name ], (err, rows) => {
        if(err) {
            return res.status(500).send(JSON.stringify({
                status: 'error',
                message: 'Unknown internal error.'
            }));
        }

        if(rows.length > 0) {
            return res.status(400).send(JSON.stringify({
                status: 'error',
                message: 'Device name already in use.'
            }));
        }

        db.run('INSERT INTO devices (id, name, location, info, sensors, owner) VALUES (?, ?, ?, ?, ? ,?)', [
            uuidv4(),
            req.body.name,
            '{"lat":0,"lon":0,"alt":0,"prec":0}',
            '{"battery":0,"cpu":0,"memory":0,"temp":0}',
            req.body.sensors,
            req.user.id
    
        ], (err) => {
            if (err) {
                return res.status(500).send(JSON.stringify({
                    status: 'error',
                    message: 'Unknown internal error.'
                }));
            }
    
            return res.send(JSON.stringify({
                status: 'ok'
            }));
        });
    });
});

router.post('/edit-device', auth.middleware, (req, res, next) => {
    if(req.body.name !== undefined && req.body.sensors !== undefined && req.body.id !== undefined) {
        req.body.name = req.body.name.trim();
        let json = "";

        try {
            json = JSON.parse(req.body.sensors);
        } catch(e) {}

        if(req.body.name !== "" && req.body.id !== "" && Array.isArray(json)) {
            if(json.length == 0) {
                return res.status(400).send(JSON.stringify({
                    status: 'error',
                    message: 'Device must have at least one sensor set.'
                }));
            }

            return next();
        }
    }

    return res.status(400).send(JSON.stringify({
        status: 'error',
        message: 'Invalid parameters.'
    }));

}, (req, res) => {
    db.all('SELECT id FROM devices WHERE owner = ? AND id = ?', [ req.user.id, req.body.id ], (err, rows) => {
        if(err) {
            return res.status(500).send(JSON.stringify({
                status: 'error',
                message: 'Unknown internal error.'
            }));
        }

        if(rows.length == 0) {
            return res.status(400).send(JSON.stringify({
                status: 'error',
                message: 'Device not found.'
            }));
        }

        db.run('UPDATE devices SET name = ?, sensors = ? WHERE id = ? AND owner = ?', [
            req.body.name,
            req.body.sensors,
            req.body.id,
            req.user.id
    
        ], (err) => {
            if (err) {
                return res.status(500).send(JSON.stringify({
                    status: 'error',
                    message: 'Unknown internal error.'
                }));
            }
    
            return res.send(JSON.stringify({
                status: 'ok'
            }));
        });
    });
});

module.exports = router;