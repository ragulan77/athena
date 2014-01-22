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

  myAppCtrls.controller('ScoreCtrl', ['$scope', 'sharedProperties', function($scope, sharedProperties) {
    $scope.nbExercises = sharedProperties.getNbExercises();
    $scope.nbRightAnswers = sharedProperties.getScore();
  }]);



  /*
    retourne la bonne vue pour faire des exercises
  */
  myAppCtrls.controller('ExerciseCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', function($scope, $http, $route, $routeParams, sharedProperties) {
    $scope.isRightAnswer = false;
    $scope.exerciseData = null;

    $http.get(Routing.generate('ath_exercise_get_data', {id: $routeParams.exerciseId})).success(function(data){
        $scope.exerciseData = data;
      });

    $scope.templateUrl = Routing.generate('ath_exercise_get_subject_view', {id: $routeParams.exerciseId});

  }]);

  /*
    retourne la bonne vue pour créer des exercises
  */
  myAppCtrls.controller('ExerciseCreateCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', function($scope, $http, $route, $routeParams, sharedProperties) {
    $scope.templateUrl = Routing.generate('ath_exercise_get_create_view', {type: $routeParams.typeExo});
  }]);


  /*
    le controlleur pour gérer le Qcm
  */
  myAppCtrls.controller('QcmCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', function($scope, $http, $route, $routeParams, sharedProperties) {
    $scope.answers = [];
    // vérifie qu'on corrige la première fois le qcm.
    $scope.checkFirstTime = true;

    if(sharedProperties.isFinish())
    {
      $scope.nextExerciseUrl = '#/score';
    }
    else
    {
      // on récupère l'url du prochain exo
      $scope.nextExerciseUrl = '#/exercise/'+sharedProperties.getNextExerciseId();
    }

    // on maj le compteur pour la fois suivante
    sharedProperties.setCurrentExercise(sharedProperties.getCurrentExercise()+1);

    $scope.oneAnswer = function(answer){
      $scope.answers = [answer];
    };

    // vérifier la réponse de l'utilisateur
    $scope.checkAnswers = function(user_answers){
      var data = {answers: JSON.stringify(user_answers)};

      var route = Routing.generate('ath_exercise_check_answers', {id: $routeParams.exerciseId});
      var config = {
        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
      }

      $http.post(route, data, config).success(function(resp){
        if(resp == "true"){
          $scope.isRightAnswer = true;
          if($scope.checkFirstTime)
          {
            $scope.checkFirstTime = false;
            sharedProperties.incrementScore();
          }
        }
        else{
          $scope.isRightAnswer = false;
          $scope.checkFirstTime = false;
        }
      });
    };
  }]);

  myAppCtrls.controller('QcmCreateCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', 'Level', 'Chapter', 'Discipline', function($scope, $http, $route, $routeParams, sharedProperties, Level, Chapter, Discipline) {

      $scope.chapters = Chapter.query();
      $scope.levels = Level.query();
      $scope.disciplines = Discipline.query();

      $scope.formActionUrl = Routing.generate('ath_exercise_set_exercise', {type: 'qcm'});

      var exercise = $scope.exercise = {
        name: '',
        question: '',
        rightAnswer: 0,
        answers: [{value: ''}]
      };

      $scope.addAnswer = function() {
        exercise.answers.push({value:''});
      };

      $scope.removeAnswer = function(answer) {
        if(exercise.answers.length > 1){
          for (var i = 0, len = exercise.answers.length; i < len; i++) {
            if (answer === exercise.answers[i]) {
              $scope.exercise.answers.splice(i, 1);
            }
          }
        }
      };

      $scope.rightAnswer = function(index){
        exercise.rightAnswer = index;
      };

  }]);

  myAppCtrls.controller('AdminCtrl', ['$scope', '$http', '$route', '$routeParams', function($scope, $http, $route, $routeParams, sharedProperties) {

      $scope.templateUrl = Routing.generate('ath_exercise_admin');
  }]);


  myAppCtrls.controller('HangmanCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', function($scope, $http, $route, $routeParams, sharedProperties) {
    $scope.answers = [];
    $scope.MAX_WRONG_ANSWERS = 3;
    // vérifie qu'on corrige la première fois le qcm.
    $scope.nbWrongAnswers = 0;

    if(sharedProperties.isFinish())
    {
      $scope.nextExerciseUrl = '#/score';
    }
    else
    {
      // on récupère l'url du prochain exo
      $scope.nextExerciseUrl = '#/exercise/'+sharedProperties.getNextExerciseId();
    }

    // on maj le compteur pour la fois suivante
    sharedProperties.setCurrentExercise(sharedProperties.getCurrentExercise()+1);

    // on initialise le mot caché
    $scope.hidden_subject = "";
    var nbHiddenLetters = $scope.exerciseData.subject.length;
    for(var cpt=0; cpt < nbHiddenLetters; cpt++)
      $scope.hidden_subject += "_ "

    // vérifier la réponse de l'utilisateur
    $scope.checkAnswers = function(user_answer){
      var answerFound = false;
      $scope.hidden_subject = ""; // on reconstruit le hidden subject
      var nbLetters = $scope.exerciseData.subject.length;
      var gameFinished = true;
      for(var cpt=0; cpt < nbLetters; cpt++)
      {
        var letter =  $scope.exerciseData.subject[cpt];

        if(letter.letter == user_answer)
        {
          answerFound = true;
          letter.discovered = true;
          $scope.hidden_subject += (letter.letter + ' ');
        }
        else
        {
          if(letter.discovered){
            $scope.hidden_subject += (letter.letter + ' ');
          }
          else
          {
            $scope.hidden_subject += ('_ ');
          }
        }

        if(!letter.discovered)
          gameFinished = false;
      }

      if(!answerFound)
        $scope.nbWrongAnswers++;

      $scope.isRightAnswer = gameFinished;

      if($scope.isRightAnswer && $scope.nbWrongAnswers < $scope.MAX_WRONG_ANSWERS)
        sharedProperties.incrementScore();
    };

  }]);


  myAppCtrls.controller('HangmanCreateCtrl', ['$scope', '$http', '$route', '$routeParams', 'sharedProperties', 'Level', 'Chapter', 'Discipline', function($scope, $http, $route, $routeParams, sharedProperties, Level, Chapter, Discipline) {

      $scope.chapters = Chapter.query();
      $scope.levels = Level.query();
      $scope.disciplines = Discipline.query();

      $scope.formActionUrl = Routing.generate('ath_exercise_set_exercise', {type: 'hangman'});
  }]);
