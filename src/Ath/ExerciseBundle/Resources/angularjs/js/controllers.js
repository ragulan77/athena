'use strict';

/* Controllers */

var myAppCtrls = angular.module('myApp.controllers', []);


  myAppCtrls.controller('InitCtrl', ['$scope', '$http', 'Level', 'sharedProperties', function($scope, $http, Level, sharedProperties) {
    $scope.levels = Level.query();
    $scope.levelChoice="test";
    $scope.exercisesGenerated = sharedProperties.getNbExercises() != null &&
                                sharedProperties.getNbExercises() > 0;

    $scope.generateExercises = function(){
      $http.get(Routing.generate('ath_exercise_get_all')).success(function(data){
        sharedProperties.setExercises(data);
        sharedProperties.setNbExercises(data.length);
        sharedProperties.setCurrentExercise(0);
        $scope.exercisesGenerated = sharedProperties.getNbExercises() != null &&
                                    sharedProperties.getNbExercises() > 0;
      });
    };

  }]);


  myAppCtrls.controller('ExerciseCtrl', ['$scope', '$http', '$route', '$routeParams', '$compile', function($scope, $http, $route, $routeParams, $compile) {
    $scope.exerciseData = null;
    $scope.answers = [];
    $scope.isRightAnswer = false;
    $http.get(Routing.generate('ath_exercise_get_data', {id: $routeParams.exerciseId})).success(function(data){
        $scope.exerciseData = data;
      });

    $scope.templateUrl = Routing.generate('ath_exercise_get_subject_view', {id: $routeParams.exerciseId});

    $scope.oneAnswer = function(answer){
      $scope.answers = [answer];
    };

    $scope.checkAnswers = function(user_answers){
      var data = {answers: JSON.stringify(user_answers)};

      var route = Routing.generate('ath_exercise_check_answers', {id: $routeParams.exerciseId});
      var config = {
        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
      }

      $http.post(route, data, config).success(function(resp){
        if(resp == "true"){
          $scope.isRightAnswer = true;
        }
        else{
          $scope.isRightAnswer = false;
        }
      });
    };

  }]);



