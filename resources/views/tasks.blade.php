@extends('app')
@section('title', ' :: Tasks')

@section('content')



<div ng-controller="TasksController">
        <div class="container ng-cloak">
            <div class="content">
                <h1 class="ng-cloak">Manage Your {{itemType}}s</h1>
                <div class="alert alert-success ng-cloak" role="alert" ng-show="message">{{message}}</div>
                <div class="alert alert-warning ng-cloak" role="alert" ng-show="warning">{{warning}}</div>
                <div ng-show="items"> 
                <ul  ng-repeat="(i,item) in items">
                	<li><a ng-click="editItem(i)"  class="ng-cloak" style="cursor: pointer;">{{item.name}}</a> <span ng-show="item.duedate">{{ item.duedate+'Z' | date:'MM/dd/yyyy @ h:mma'  }}</span></li>
                </ul>
                <div style="height:12px;"></div>
                <form ng-submit="newItem()">
                	<input name="name" ng-model="newField.name">
                	<button class="btn btn-primary" type="submit">New {{itemType}}</button>
                </form>
                </div>
            </div>
        </div>
</div>

<script type="text/ng-template" id="editor.html">
        <div class="modal-header">
            <h3 class="modal-title">{{title}}</h3>
        </div>
        <div class="modal-body">
        	<form ng-submit="submit()">
        	<div ng-repeat="(fname,fvalue) in formFields" class="row">
                	<label for="{{fname}}" class="col-md-4">{{fvalue.label}}</label>
                	<input class="col-md-6" name="{{fname}}" type="{{fvalue.type}}" ng-model="item[fname]" parse-int ng-true-value="1" ng-false-value="0">
            </div>
            <div class="col-md-2"></div>
            </form>
        </div>
        <div class="modal-footer">
        	<button class="btn btn-danger pull-left" type="button" ng-click="delete()" ng-show="id"><span class="glyphicon glyphicon-trash"></span></button>
            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
            <button class="btn btn-primary" type="button" ng-click="submit()">OK</button>
        </div>
    </script>

    <script type="text/ng-template" id="delete.html">
        <div class="modal-header">
            <h3 class="modal-title">Delete {{item.name}}?</h3>
        </div>
        <div class="modal-body">
            Are You sure you want to delete {{item.name}}? 
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" type="button" ng-click="delete_confirm()">DELETE</button>
            <button class="btn btn-primary" type="button" ng-click="cancel()">Cancel</button>
        </div>
    </script>

<script>
	
(function() {

    var TasksController = function($scope, $http,$uibModal ) {
    	$scope.itemType= 'Task';
    	$scope.newField = {'name':''};
    	
    	

		var getAll = function() {
    	  return $http.get("/tasks/")
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
      		templateUrl: 'editor.html',
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

      $scope.items= [[ json_encode($items) ]];
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
      		templateUrl: 'delete.html',
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
	
</script>
    
@endsection
