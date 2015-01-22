angular.module('plunker', ['ui.bootstrap']);
var DatepickerDemoCtrl = function ($scope, $timeout) {
  $scope.minDate = '2013-10-15';
  $scope.maxDate = '2013-10-25';
  
  $scope.today = function() {
    $scope.dt = new Date();
  };
  $scope.today();

  $scope.showWeeks = true;
  $scope.toggleWeeks = function () {
    $scope.showWeeks = ! $scope.showWeeks;
  };

  $scope.clear = function () {
    $scope.dt = null;
  };


  $scope.open = function() {
    $timeout(function() {
      $scope.opened = true;
    });
  };

  $scope.dateOptions = {
    'year-format': "'yy'",
    'starting-day': 1
  };
};