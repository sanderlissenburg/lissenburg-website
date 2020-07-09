import "reflect-metadata";
import express from 'express';
import {container} from "tsyringe";
import {Foo} from "./Foo";
import {Bar} from "./Bar";
import mysql, {Connection} from 'mysql';

container.register<Bar>(Bar, {useValue: new Bar('Sander Lissenburg')});
container.register<Foo>(Foo, Foo);

container.register<Connection>('mysqlConnection', {
    useFactory: () => {
        return mysql.createConnection({
            host     : 'mysql',
            user     : 'root',
            password : 'secret',
            database : 'lissenburg'
        });
    }
});

const connection = container.resolve<Connection>('mysqlConnection');
connection.connect((err) => {
    if (err) {
        console.log(err.message);
        return;
    }

    console.log('Connected')
});

const app = express();

app.get('/', (req, res) => {

    res.send(container.resolve(Foo).foobar());
})

app.listen(3000, () => {
    console.log('Listing on port 3000...');
})
