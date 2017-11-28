/**
 * This is an example of how you could break down a js file into parts
 * with es6. Here the `commonInit()` function will fire on all pages
 * because that function is called in the `init()` function of `common`
 * in app.js.
 *
 * `commonFinalize()` will fire on all pages once the `init()` functions
 * of each route in app.js have been fired. It is called in the
 * `finalize()` function of `common` in app.js.
 *
 */
import { sampleMessage, sampleAddModule } from './sampleModule';

// This function will fire on init() in app.js
export function commonInit() {
  console.log('See commonInit() in commonScripts.js \n' +
              '--- \n' +
              sampleMessage() + '\n' +
              sampleAddModule(3,3)
             );
}

// This function will fire on finalize() in app.js
export function commonFinalize() {
  console.log('See commonFinalize() in commonScripts.js');
}