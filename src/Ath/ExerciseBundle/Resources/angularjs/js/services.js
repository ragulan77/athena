'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
var myAppServices = angular.module('myApp.services', ['ngResource']).
  value('version', '0.1');

myAppServices.factory('Exercise', ['$resource',
  function($resource){
    return $resource(Routing.generate('ath_exercise_get_all'), {}, {
      query: {method:'GET', params:{exerciseId:'exercises'}, isArray:true}
    });
  }]);

myAppServices.factory('Level', ['$resource',
  function($resource){
    return $resource(Routing.generate('ath_exercise_levels'), {}, {
      query: {method:'GET', params:{levelId:'levels'}, isArray:true}
    });
  }]);

myAppServices.factory('Discipline', ['$resource',
  function($resource){
    return $resource(Routing.generate('ath_cours_disciplines'), {}, {
      query: {method:'GET', params:{disciplineId:'disciplines'}, isArray:true}
    });
  }]);

myAppServices.factory('Chapter', ['$resource',
  function($resource){
    return $resource(Routing.generate('ath_exercise_chapters'), {}, {
      query: {method:'GET', params:{chapterId:'chapters'}, isArray:true}
    });
  }]);

myAppServices.service('sharedProperties', function () {
        var exercises = null;
        var nbExercises = null;
        var currentExercise = null; // démarre à 0
        var score = 0;
        return {
            getExercises: function () {
                return exercises;
            },
            getNbExercises: function(){
                return nbExercises;
            },
            getCurrentExercise: function(){
                return currentExercise;
            },
            getNextExerciseId: function(){
              if (currentExercise < nbExercises-1)
                return exercises[currentExercise+1].id;
              else
                return exercises[currentExercise].id;
            },
            getScore: function()
            {
              return score;
            },
            setExercises: function(value) {
                exercises = value;
            },
            setNbExercises: function(value){
              nbExercises = value;
            },
            setCurrentExercise: function(value){
              if (value < nbExercises){ //si invalide on ne maj pas
                currentExercise = value;
              }
            },
            incrementScore: function(){
              score++;
            },
            isFinish: function(){
              if(currentExercise == nbExercises-1)
                return true;
              return false;
            }
        };
    });
