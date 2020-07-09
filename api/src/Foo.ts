import {Bar} from "./Bar";
import {injectable} from "tsyringe";

@injectable()
export class Foo {
    constructor(public bar: Bar) {
    }

    foobar() {
        return this.bar.value;
    }
}
