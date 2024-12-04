var express = require('express');
var path = require('path');
var db = require('../../db');
var auth = require('../auth');
var { v4: uuidv4 } = require('uuid');

var router = express.Router();

router.get('/get-records', auth.middleware, (req, res, next) => {
    if(req.body.device !== undefined && req.body.device !== "") {
        return next()
    }

    return res.status(400).send(JSON.stringify({
        status:'ok',
        message: 'Invalid parameters.'
    }));
}, (req, res, next) => {
    db.get('SELECT id FROM devices WHERE id = ? AND owner = ?', [ req.body.device, req.user.id ], (err, row) => {
        if(err) {
            return res.status(500).send(JSON.stringify({
                status: 'error',
                message: 'Unknown internal error.'
            }));
        }

        console.log('SOCO', row);

        if(row === undefined) {
            return res.status(400).send(JSON.stringify({
                status: 'error',
                message: 'Device not found.'
            }));
        }

        return next();
    });
}, (req, res) => {
    db.all('SELECT * FROM records WHERE device = ?', [ req.body.device ], (err, rows) => {
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

router.post('/add-record', auth.middleware, (req, res, next) => {
    if(
        req.body.id !== undefined &&
        req.body.key !== undefined &&
        req.body.value !== undefined &&
        req.body.id !== "" &&
        req.body.key !== "" &&
        req.body.value !== ""
    ) {
        return next();
    }

    return res.status(400).send(JSON.stringify({
        status: 'error',
        message: 'Invalid parameters.'
    }));
}, (req, res) => {
    let userkey = req.body.id;
    let deviceid = userkey.split("-");

    if(deviceid.length !== 6 && deviceid[0].length !== 1) {
        return res.status(400).send(JSON.stringify({
            status: 'error',
            message: 'Invalid id.'
        }));
    }

    let userid = deviceid.splice(0, 1)[0];
    deviceid = deviceid.join('-');

    console.log('SOCO', userid, deviceid);

    db.get('SELECT sensors FROM devices WHERE id = ? AND owner = ?', [ deviceid, userid ], (err, row) => {
        if(err) {
            return res.status(500).send(JSON.stringify({
                status: 'error',
                message: 'Unknown internal error.'
            }));
        }

        if(row === undefined) {
            return res.status(400).send(JSON.stringify({
                status: 'error',
                message: 'Device not found.'
            }));
        }

        let sensors = [];
        
        try {
            sensors = JSON.parse(row.sensors);
        } catch(e) {}

        let enablesSensors = sensors.map(s => {
            return s.key
        });

        if(enablesSensors.includes(req.body.key)) {
            db.run('INSERT INTO records (id, device, date, rkey, rvalue) VALUES (?, ?, DateTime(\'now\'), ?, ?)', [
                uuidv4(),
                deviceid,
                req.body.key,
                req.body.value

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
            
        } else {
            return res.status(400).send(JSON.stringify({
                status: 'error',
                message: 'Sensor not enabled.'
            }));
        }
    });
});

module.exports = router;