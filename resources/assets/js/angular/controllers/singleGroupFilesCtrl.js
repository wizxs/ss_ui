var ssModule = angular.module('skoolspace');

ssModule.controller('SingleGroupFilesController', ['$scope','fileService', 'toaster',
    function($scope, fileService, toaster){

        //Controller variables.
        $scope.search = {};
        $scope.pageSize = 12;
        $scope.allFiles = [];
        $scope.loading = true;
        $scope.currentPage = 1;
        $scope.numberOfFiles = 9;


        $scope.moreIndex = null;
        $scope.topicIndex = null;
        $scope.addingIndex = null;
        $scope.fileNameLength = 18;
        $scope.sharingIndex = null;

        $scope.fileToBeDeleted = {};
        $scope.fileToBeAddedToBagPack = {};

        //Controller functions
        $scope.showMoreFiles = function(){
            $scope.numberOfFiles += 6;
        };

        $scope.deleteFile = function(file)
        {
            $scope.fileToBeDeleted = file;
        };

        $scope.addToBackpack = function(file, index){
            $scope.addingIndex = index;
            var fileId = file.id;
            var backpackPromise = fileService.addToBackpack(fileId);
            backpackPromise.success(function(){
                $scope.addingIndex = null;
                file.inBackpack = true;
                toaster.pop("success","", "The file was successfully added to you backpack.");
            });
            backpackPromise.error(function(){
                $scope.addingIndex = null;
                toaster.pop("errors", "", "The file is already in your backpack.");
            });
        };

        $scope.showMoreDetails = function(index)
        {
            $scope.moreIndex = index;
            $scope.fileNameLength = 100;
        };

        $scope.showLessDetails = function()
        {
            $scope.moreIndex = null;
            $scope.fileNameLength = 20;
        };

        $scope.filterWithTopic = function(topicName ,index) {
            $scope.search = {
                'topic':  topicName
            };
            if(topicName == '')
            {
                $scope.topicIndex = null;
            } else {
                $scope.topicIndex = index;
            }

        };

        $scope.fileInit = function() {
            $scope.loading = true;
            var groupUsername = $('#group').data('name');
            fileService.getAllGroupFiles(groupUsername).success(function(data) {
                $scope.allFiles = data.data;
                $scope.loading = false;
            });

            fileService.getAllGroupTopics(groupUsername).success(function(data) {
                $scope.allTopics = data.data
            })
        };


        $scope.fileInit();

    }]);