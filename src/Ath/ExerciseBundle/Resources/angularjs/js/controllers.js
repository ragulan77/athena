'use strict';

/* Controllers */

var myAppCtrls = angular.module('myApp.controllers', []);


  myAppCtrls.controller('InitCtrl', ['$scope', '$http', 'Level', 'sharedProperties', function($scope, $http, Level, sharedProperties) {
    $scope.levels = Level.query();
    $scope.levelChoice="test";
    $scope.exercisesGenerated = sharedProperties.getNbExercises() != null &&
                                sharedProperties.getNbExercises() > 0;
    $scope.nextExerciseUrl = "";

    $scope.generateExercises = function(){
      $http.get(Routing.generate('ath_exercise_get_all')).success(function(data){
        sharedProperties.setExercises(data);
        sharedProperties.setNbExercises(data.length);
        sharedProperties.setCurrentExercise(0);
        $scope.exercisesGenerated = sharedProperties.getNbExercises() != null &&
                                    sharedProperties.getNbExercises() > 0;
        $scope.nextExerciseUrl =  "#/exercise/"+data[0].id;
      });
    };

  }]);


  myAppCtrls.controller('ExerciseCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', function($scope, $http, $route, $routeParams, sharedProperties) {
    $scope.exerciseData = null;
    $scope.answers = [];
    $scope.isRightAnswer = false;
    // on récupère l'url du prochain exo
    $scope.nextExerciseUrl = '#/exercise/'+sharedProperties.getNextExerciseId();
    // on maj le compteur pour la fois suivante
    sharedProperties.setCurrentExercise($scope.nextExercise+1);


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



