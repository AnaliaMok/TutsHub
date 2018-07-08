/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function () {
  var menuIcon = void 0;
  var accordion = void 0;

  window.onload = init;

  function init() {
    menuIcon = document.getElementById('menuIcon');
    menuIcon.addEventListener('click', toggleNav);

    accordion = document.querySelector('.nav__accordion');
    var searchFrom = document.querySelector('#searchForm');

    if (searchForm !== undefined) {
      var searchBox = searchForm.querySelector('input[type=text]');
      searchBox.addEventListener('keypress', search);
    }
  }

  function toggleNav() {
    var closeClass = 'nav__accordion--close';
    var openClass = 'nav__accordion--open';

    if (accordion.classList.contains(closeClass)) {
      accordion.classList.remove(closeClass);
      accordion.classList.add(openClass);
    } else {
      accordion.classList.remove(openClass);
      accordion.classList.add(closeClass);
    }
    console.log(accordion.classList);
  }

  // Search Method Launched By Ajax
  function search(e) {
    if (e.keyCode === 13) {
      e.preventDefault();
      var keyword = e.target.value;
      var contentType = e.target.getAttribute('data-contenttype');

      var requestUrl = 'http://tutshub/search?keyword=' + keyword + '&contentType=' + contentType;
      fetch(requestUrl).then(function (res) {
        return res.json();
      }).then(function (result) {
        console.log({ result: result });
        var page = document.querySelector('.page');
        if (page) {
          page.innerHTML = result.html;
        }
      }, function (error) {
        console.log({ error: error });
      });
    }
  }

  function searchPagination(e) {
    if (document.querySelector('.search__pagination') !== null) {
      e.preventDefault();
      console.log({ e: e });
    }
  }

  return {
    'search': search,
    'searchPagination': searchPagination
  };
})();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);