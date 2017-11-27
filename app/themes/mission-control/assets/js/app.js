import Router from './modules/DomBasedRouter';
import { testModule } from './modules/testModule';

let routes = {
  'common': {
    init() {
      console.log('hello');
      $('body').css('background-color', '#bada55');
      testModule();
    }
  }
};

let router = new Router(routes);

router.load();

