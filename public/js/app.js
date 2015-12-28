var app = angular.module("laratasks", ['ui.bootstrap']);

(function() {

    
    
    var NavbarController = function($scope, $window ) {
    	
    	var navbarResponsive = function() {
    		if ($window.innerWidth <= 768) {
        		$scope.navCollapsed = true;
    		} else {
    			$scope.navCollapsed = false;
    		}
    	}
    	
    	var w = angular.element($window);
    	 	
		w.bind('resize', function () {
		//	console.log(w);
			navbarResponsive();
		});
    	
    	navbarResponsive();
    }

    app.controller("NavbarController", NavbarController);
  }

  ());