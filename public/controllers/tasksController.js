(function() {

    var TasksController = function($scope, $http,$uibModal ) {
    	$scope.itemType= 'Task';
    	$scope.newField = {'name':''};
    	
    	

		var getAll = function() {
    	  return $http.get("/tasks")
    	    .then(function(response) {
    	    	console.log(response);
    	      $scope.items = response.data.items;
    	      if(!$scope.items.length) {
      			$scope.warning = 'No '+$scope.itemType+'s Found';
      		  } else {
      		  	delete $scope.warning;
      		  }
    	    });
    	}
    	
    	$scope.newItem = function() {
    		delete $scope.warning;
    		if(!$scope.newField.name) {
    			$scope.warning = 'New Task was blank';
    			return;
    		}
    		
    		return $http.post("/tasks",$scope.newField)
    	    	.then(function(response) {
    	    		console.log(response);
	    			$scope.message = $scope.newField.name+' Was Created';
	    			$scope.newField.name = '';
	    			getAll();
    	    	});
		
    	}
    	
    	$scope.editItem = function(id) {
			var item = angular.copy($scope.items[id]);
			var modalInstance = $uibModal.open({
      		animation: $scope.animationsEnabled,
      		templateUrl: 'views/editTask.html',
      		controller: 'ItemEditorController',
      		resolve: {
      			title: function() { 
      					return 'Edit '+item.name;
      				},
        			item: function () {
		          		return item;
        			}
      		}
    		});
    		modalInstance.result.then(function (modalResult) {
    			$scope.message=modalResult;
    			getAll();
    		});
    		
    	}

      $scope.items= [];
      getAll();
      if(!$scope.items.length) {
      	$scope.warning = 'No '+$scope.itemType+'s Found';
      }
      

    }
    
    var ItemEditorController = function($scope, $http,$modalInstance,title,item,$uibModal ) {
    	$scope.title = title;
    	$scope.id = item.id;
    	delete item.$$hashKey;
    	delete item.created_at;
    	delete item.updated_at;
    	delete item.deleted_at;
    	if(item.duedate) {
	    	item.duedate = new Date(item.duedate);
		}
    	$scope.item = item;
    	var origName = item.name;
    	
    	$scope.formFields = {
    		'name':{'label':'Name','type':'text'},
    		'done':{'label':'Done','type':'checkbox'},
    		'duedate':{'label':'Due Date','type':'datetime-local'}
    	};
    	
    	$scope.cancel = function () {
    		$modalInstance.dismiss('cancel');
  		};
  		
  		$scope.submit = function () {
  			if($scope.item.id) {
  				return $http.put("/tasks/"+$scope.item.id,$scope.item)
    	    	.then(function(response) {
    	    		console.log(response);
	    			$modalInstance.close(origName+' Was Updated');
    	    	});
  			} else {
  				return $http.post("/tasks",$scope.item)
    	    	.then(function(response) {
    	    		console.log(response);
	    			$modalInstance.close($scope.item.name+' Was Created');
    	    	});
    	   }

  		};
    	
    	$scope.delete = function(id) {
    		console.log(id);

			var modalInstance = $uibModal.open({
      		animation: $scope.animationsEnabled,
      		templateUrl: 'views/deleteTask.html',
      		controller: 'ItemDeleteController',
      		resolve: {
      			item: function() { 
      					return $scope.item;
      				}
      		}
    		});
    		
    		modalInstance.result.then(function (modalResult) {
    			if(modalResult=='DELETE') {
    				$modalInstance.close($scope.item.name+' Was Deleted');
    			}
    		});

    	}
    	
    }
    
     var ItemDeleteController = function($scope, $http,$modalInstance,item ) {
     	$scope.item = item;

    	$scope.cancel = function () {
    		$modalInstance.dismiss('cancel');
  		};
  		
  		$scope.delete_confirm = function() {
			return $http.delete("/tasks/"+$scope.item.id)
    	    .then(function(response) {
    	    	console.log(response);
    	    	$modalInstance.close('DELETE');
    	    });
  			
  		}

     }

    app.controller("TasksController", TasksController);
    app.controller("ItemEditorController", ItemEditorController);
    app.controller("ItemDeleteController", ItemDeleteController);
  }

  ());	