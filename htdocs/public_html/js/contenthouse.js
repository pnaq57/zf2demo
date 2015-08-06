var app = angular.module('myapp', []);

app.controller('FormCtrl', function($scope, $rootScope) {
    $scope.removeMarker = function() {
        
    }
    $scope.fightTitleRequired = true;
    function reverse(s) {
        return s.split('').reverse().join('');
    }
    $rootScope.id = $scope.id;
    $scope.checkRequired = function(fightTitle) {
        $scope.fightTitle = fightTitle;
        console.log(fightTitle);
        if ($scope.fightTitle.length > 0) {
            $scope.fightTitleRequired = false;
        } else {
            $scope.fightTitleRequired = true;
        }
        return fightTitle;
    }
    
    $scope.fightTitleChange = function() {
        console.log($scope.fightTitle);
        if ($scope.fightTitle.length > 0) {
            $scope.fightTitleRequired = false;
        } else {
            $scope.fightTitleRequired = true;
        }
    }
    
    $scope.changeTimeCode = function(time) {
        var originStr = time;
        time = time.replace(/:/g, '');
        var reg = /^\d+$/;
        
        if (!reg.test(time)) {
            alert('Die Eingabe enthält nicht nur Zahlen. Bitte korrigieren! ' + originStr);
            return originStr;
        }
        /*
        if (time.length != 8) {
            alert('Es muss eine 8-stellige Zahl verwendet werden. Aktuell verwendet: ' + time.length);
            return originStr;
        }
        */
        
        time = reverse(time);
        var newTime = time.match(/(.{1,2})/g);
        newTime = newTime.reverse();
        for (var t in newTime) {
            newTime[t] = reverse(newTime[t]);
        }
        newTime = newTime.join(':');
        return newTime;
    }
	
})
.controller('MarkerCtrl', function($scope) {

})
.controller('InterviewCtrl', function($scope) {

})
.directive('ipmAddMarker', function($compile) {
    return {
        restrict: "E",
        template: "<div class='btn btn-default' ng-click='addMarker()'>Add Moment</div>",
        link: function($scope, $element, $attrs) {
            var initIndex = 0;            
            $scope.addMarker = function() {
                var time = new Date().getTime();
                var el = ['<div class="row" id="marker_zone_' + initIndex + '">',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Typ*</label>',
                            '<select class="form-control" name="actions[' + initIndex + '][action]" required="" ng-model="actions_action' + time + '">',
                                '<option></option>',
                                '<option value="Error / Sound">Error / Sound</option>',
                                '<option value="Error / Picture">Error / Picture</option>',
                                '<option value="KD">KD</option>',
                                '<option value="KO">KO</option>',
                                '<option value="TKO">TKO</option>',
                                '<option value="Highlights">Highlights</option>',
                            '</select>',
                            '<span ng-show="!actions_action' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>TC (HH:MM:SS:FF)*</label>',
                            '<input type="text" \n\
                                ng-blur="actions_' + time + '_action_from=changeTimeCode(actions_' + time + '_action_from)" \n\
                                required="" \n\
                                ng-init="actions_' + time + '_action_from=\'\'" \n\
                                ng-model="actions_' + time + '_action_from" \n\
                                name="actions[' + initIndex + '][action_from]" \n\
                                class="form-control" \n\
                                placeholder="TC (HH:MM:SS:FF)">',
                            '<span ng-if="actions_' + time + '_action_from.length == undefined || actions_' + time + '_action_from.length<8">Es werden 8 Zeichen benötigt.</span>',
                            '<span ng-if="actions_' + time + '_action_from.length>11">Es werden 8 Zeichen benötigt.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Kommentar</label>',
                            '<input type="text" \n\\n\
                                name="actions[' + initIndex + '][comment]" \n\
                                class="form-control" \n\
                                placeholder="Kommentar">',                            
                        '</div>',
                    '</div>',
                    '<div class="col-xs-1 col-md-1">',
                        '<div class="form-group">',
                            '<div class="ipm_rm_bnt btn btn-default glyphicon glyphicon-remove form-control" ng-click="removeMarker(\'marker_zone_' + initIndex + '\')"> </div>',
                        '</div>',
                    '</div>',
                    '</div>'
                    ].join('\n');
                
                angular.element(document.getElementById("marker_zone")).append($compile(el)($scope));
                initIndex --;
            }
            $scope.removeMarker = function(el) {
                if (confirm('Are you sure you want to remove this?')) {
                    angular.element(document.getElementById(el)).remove();
                }
            }
            $scope.softRemoveMarker = function(el, id) {
                if (confirm('Are you sure you want to remove this?')) {
                    var hideAction = '<input type="hidden" name="actions['  + id + '][toRemove]" value="'  + id + '">';
                    var elObj = document.getElementById(el);
                    angular.element(elObj).append(hideAction);
                    angular.element(elObj).hide();
                    //angular.element(document.getElementById(el)).remove();
                }
            }  
    }
        
        
    }
})
.directive('ipmAddInterview', function($compile) {
    return {
        restrict: "E",
        template: "<div class='btn btn-default' ng-click='addInterview()'>Add Interview</div>",
        link: function($scope, $element, $attrs) {
            var initIndex = 0;
            
            $scope.addInterview = function() {
                var time = new Date().getTime();
                var el = ['<div class="row" id="interviews_zone_' + initIndex + '">',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Partner*</label>',
                            '<input required="" \n\
                                type="text" name="interviews[' + initIndex + '][fighter]" \n\
                                class="form-control" \n\
                                placeholder="Partner"\n\
                                ng-model="interviews_fighter_' + time + '" \n\
                                >',
                            '<span ng-show="!interviews_fighter_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                        
                    '</div>',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>TC Start (HH:MM:SS:FF)*</label>',
                            '<input \n\
                                required="" \n\ \n\
                                ng-blur="interviews_' + time + '_action_in=changeTimeCode(interviews_' + time + '_action_in)" \n\
                                value="" ng-init="interviews_' + time + '_action_in=\'\'" \n\
                                ng-model="interviews_' + time + '_action_in" type="text" name="interviews[' + initIndex + '][action_in]" \n\
                                class="form-control" \n\
                                placeholder="TC Start (HH:MM:SS:FF)">',
                            '<span ng-if="interviews_' + time + '_action_in.length == undefined || interviews_' + time + '_action_in.length<8">Es werden 8 Zeichen benötigt.</span>',
                            '<span ng-if="interviews_' + time + '_action_in.length>11">Es werden 8 Zeichen benötigt.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>TC Ende (HH:MM:SS:FF)*</label>',
                            '<input \n\
                                required="" \n\
                                ng-blur="interviews_' + time + '_action_out=changeTimeCode(interviews_' + time + '_action_out)" \n\
                                value="" ng-init="interviews_' + time + '_action_out=\'\'" \n\
                                ng-model="interviews_' + time + '_action_out" type="text" name="interviews[' + initIndex + '][action_out]" \n\
                                class="form-control" \n\
                                placeholder="TC Ende (HH:MM:SS:FF)">',
                            '<span ng-if="interviews_' + time + '_action_out.length == undefined || interviews_' + time + '_action_out.length < 8">Es werden 8 Zeichen benötigt.</span>',
                            '<span ng-if="interviews_' + time + '_action_out.length>11">Es werden 8 Zeichen benötigt.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-2 col-md-2">',
                        '<div class="form-group" >',
                            '<label>Sprache*</label>',
                            '<select\n\
                                class="form-control" \n\
                                name="interviews[' + initIndex + '][language]"\n\
                                required="" \n\
                                ng-model="interviews_language_' + time + '" \n\
                            >',
                                '<option></option>',
                                '<option value="ger">Deutsch</option>',
                                '<option value="out">Englisch</option>',
                                '<option value="fra">Französisch</option>',
                                '<option value="others">others</option>',
                            '</select>',
                            '<span ng-show="!interviews_language_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-1 col-md-1">',
                        '<div class="form-group">',
                            '<label></label>',
                            '<div class="ipm_rm_bnt btn btn-default glyphicon glyphicon-remove form-control" ng-click="removeInterview(\'interviews_zone_' + initIndex + '\')">  </div>',
                        '</div>',
                    '</div>',
                    '</div>'
                    ].join('\n');
                
                angular.element(document.getElementById("interviews_zone")).append($compile(el)($scope));
                initIndex --;
            }
            $scope.removeInterview = function(el) {
                if (confirm('Are you sure you want to remove this?')) {
                    angular.element(document.getElementById(el)).remove();
                }
            }
            $scope.softRemoveInterview = function(el, id) {
                if (confirm('Are you sure you want to remove this?')) {
                    var hideAction = '<input type="hidden" name="interviews['  + id + '][toRemove]" value="'  + id + '">';
                    var elObj = document.getElementById(el);
                    angular.element(elObj).append(hideAction);
                    angular.element(elObj).hide();
                    //angular.element(document.getElementById(el)).remove();
                }
            }  
    }
        
        
    }
})


.directive('sfDescription', function($compile) {
    return {
        restrict: "E",
        template: "<div class='btn btn-default' ng-click='addSFDescription()'>Beschreibung hinzufügen</div>",
        link: function($scope, $element, $attrs) {
            var initIndex = 0;
            
            $scope.addSFDescription = function() {
                var time = new Date().getTime();
                var el = ['<div class="row" id="sfdescription_zone_' + initIndex + '">',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Beschreibung*</label>',
                            '<textarea \n\
                                required="" \n\
                                ng-value="" \n\
                                ng-model="sfdescription_' + time + '_long_description" type="text" name="sfdescription[' + initIndex + '][long_description]" \n\
                                class="form-control" \n\
                                placeholder="Beschreibung">\n\
                            </textarea>',
                            '<span ng-show="!sfdescription_' + time + '_long_description">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-2 col-md-2">',
                        '<div class="form-group" >',
                            '<label>Sprache*</label>',
                            '<select\n\
                                class="form-control" \n\
                                name="sfdescription[' + initIndex + '][language]"\n\
                                required="" \n\
                                ng-model="sfdescription_language_' + time + '" \n\
                            >',
                                '<option></option>',
                                '<option value="deutsch">deutsch</option>',
                                '<option value="englisch">englisch</option>',
                                '<option value="französisch">französisch</option>',
                            '</select>',
                            '<span ng-show="!sfdescription_language_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-2 col-md-2">',
                        '<div class="form-group" >',
                            '<label>Beschreibungstyp*</label>',
                            '<select\n\
                                class="form-control" \n\
                                name="sfdescription[' + initIndex + '][type]"\n\
                                required="" \n\
                                ng-model="sfdescription_type_' + time + '" \n\
                            >',
                                '<option></option>',
                                '<option value="Short description">Short description</option>',
                                '<option value="Long description">Long description</option>',
                            '</select>',
                            '<span ng-show="!sfdescription_type_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-1 col-md-1">',
                        '<div class="form-group">',
                            '<label></label>',
                            '<div class="ipm_rm_bnt btn btn-default glyphicon glyphicon-remove form-control" ng-click="removeSfDescription(\'sfdescription_zone_' + initIndex + '\')">  </div>',
                        '</div>',
                    '</div>',
                    '</div>'
                    ].join('\n');
                
                angular.element(document.getElementById("sfdescription_zone")).append($compile(el)($scope));
                initIndex --;
            }
            $scope.removeSfDescription = function(el) {
                if (confirm('Are you sure you want to remove this?')) {
                    angular.element(document.getElementById(el)).remove();
                }
            }
            $scope.softRemoveSfDescription = function(el, id) {
                if (confirm('Are you sure you want to remove this?')) {
                    var hideAction = '<input type="hidden" name="sfdescription['  + id + '][toRemove]" value="'  + id + '">';
                    var elObj = document.getElementById(el);
                    angular.element(elObj).append(hideAction);
                    angular.element(elObj).hide();
                    //angular.element(document.getElementById(el)).remove();
                }
            }  
    }
        
        
    }
})

.directive('sfFighter', function($compile) {
    return {
        restrict: "E",
        template: "<div class='btn btn-default' ng-click='addSFFighter()'>Kämpfer hinzufügen</div>",
        link: function($scope, $element, $attrs) {
            var initIndex = 0;
            
            $scope.addSFFighter = function() {
                var time = new Date().getTime();
                var el = ['<div class="row" id="sffighter_zone_' + initIndex + '">',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Name*</label>',
                            '<input required="" \n\
                                class="fighter" \n\\n\
                                ng-value="" \n\
                                type="hidden"\n\
                                name="sffighter[' + initIndex + '][id]" \n\
                                ng-model="sffighter_id_' + time + '" \n\
                                >',
                            '<input required="" \n\
                                ipm-autocomplete \n\
                                type="text"\n\
                                name="sffighter[' + initIndex + '][fullname]" \n\
                                class="form-control" \n\
                                placeholder="Kämpfer"\n\
                                ng-model="sffighter_fullname_' + time + '" \n\
                                >',
                            '<span ng-show="!sffighter_fullname_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',                        
                    '</div>',
                    '<div class="col-xs-1 col-md-1">',
                        '<div class="form-group">',
                            '<label></label>',
                            '<div class="ipm_rm_bnt btn btn-default glyphicon glyphicon-remove form-control" ng-click="removeSfFighter(\'sffighter_zone_' + initIndex + '\')">  </div>',
                        '</div>',
                    '</div>',
                    '</div>'
                    ].join('\n');
                
                angular.element(document.getElementById("sffighter_zone")).append($compile(el)($scope));
                initIndex --;
            }
            $scope.removeSfFighter = function(el) {
                if (confirm('Are you sure you want to remove this?')) {
                    angular.element(document.getElementById(el)).remove();
                }
            }
            $scope.softRemoveSfFighter = function(el, id) {
                if (confirm('Are you sure you want to remove this?')) {
                    var hideAction = '<input type="hidden" name="sffighter['  + id + '][toRemove]" value="'  + id + '">';
                    var elObj = document.getElementById(el);
                    angular.element(elObj).append(hideAction);
                    angular.element(elObj).hide();
                    //angular.element(document.getElementById(el)).remove();
                }
            }  
    }
        
        
    }
})

.directive('sfArtwork', function($compile) {
    return {
        restrict: "E",
        template: "<div class='btn btn-default' ng-click='addSfArtwork()'>Artwork hinzufügen</div>",
        link: function($scope, $element, $attrs) {
            var initIndex = 0;
            
            $scope.addSfArtwork = function() {
                var time = new Date().getTime();
                var el = ['<div class="row" id="sfartwork_zone_' + initIndex + '">',
                    '<div class="col-xs-3 col-md-3">',
                        '<div class="form-group" >',
                            '<label>Dateiname</label>',
                            '<input \n\
                                valid-file \n\
                                ng-required="true" \n\
                                type="file"\n\
                                name="sfartwork[' + initIndex + '][file]" \n\
                                class="form-control" \n\
                                ng-model="sfartwork_file_' + time + '" \n\
                                >',
                            '<span ng-show="!sfartwork_file_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',                        
                    '</div>',
                    '<div class="col-xs-2 col-md-2">',
                        '<div class="form-group" >',
                            '<label>Dateityp*</label>',
                            '<select\n\
                                class="form-control" \n\
                                name="sfartwork[' + initIndex + '][file_type]"\n\
                                ng-required="true" \n\
                                ng-model="sfartwork_file_type_' + time + '" \n\
                            >',
                                '<option></option>',
                                '<option value="Thumbnail">Thumbnail</option>',
                                '<option value="Poster">Poster</option>',
                            '</select>',
                            '<span ng-show="!sfartwork_file_type_' + time + '">Dieses Feld ist ein Pflichtfeld.</span>',
                        '</div>',
                    '</div>',
                    '<div class="col-xs-1 col-md-1">',
                        '<div class="form-group">',
                            '<label></label>',
                            '<div class="ipm_rm_bnt btn btn-default glyphicon glyphicon-remove form-control" ng-click="removeSfArtwork(\'sfartwork_zone_' + initIndex + '\')">  </div>',
                        '</div>',
                    '</div>',
                    '</div>'
                    ].join('\n');
                
                angular.element(document.getElementById("sfartwork_zone")).append($compile(el)($scope));
                initIndex --;
            }
            $scope.removeSfArtwork = function(el) {
                if (confirm('Are you sure you want to remove this?')) {
                    angular.element(document.getElementById(el)).remove();
                }
            }
            $scope.softRemoveSfArtwork = function(el, id) {
                if (confirm('Are you sure you want to remove this?')) {
                    var hideAction = '<input type="hidden" name="sffighter['  + id + '][toRemove]" value="'  + id + '">';
                    var elObj = document.getElementById(el);
                    angular.element(elObj).append(hideAction);
                    angular.element(elObj).hide();
                    //angular.element(document.getElementById(el)).remove();
                }
            }  
    }
        
        
    }
})

.directive('ipmAutocomplete', function($http, $interpolate, $parse) {

    // Usage:

    //  For a simple array of items
    //  <input type="text" class="form-control" my-autocomplete url="/some/url" ng-model="criteria.employeeNumber"  />

    //  For a simple array of items, with option to allow custom entries
    //  <input type="text" class="form-control" my-autocomplete url="/some/url" allow-custom-entry="true" ng-model="criteria.employeeNumber"  />

    //  For an array of objects, the label attribute accepts an expression.  NgModel is set to the selected object.
    //  <input type="text" class="form-control" my-autocomplete url="/some/url" label="{{lastName}}, {{firstName}} ({{username}})" ng-model="criteria.employeeNumber"  />

    //  Setting the value attribute will set the value of NgModel to be the property of the selected object.
    //  <input type="text" class="form-control" my-autocomplete url="/some/url" label="{{lastName}}, {{firstName}} ({{username}})" value="id" ng-model="criteria.employeeNumber"  />

    var directive = {            
        restrict: 'A',
        require: 'ngModel',
        compile: compile
    };

    return directive;

    function compile(elem, attrs) {
        var modelAccessor = $parse(attrs.ngModel), labelExpression = attrs.label;
        if (window.location.origin == undefined) {
            window.location.origin = window.location.protocol + '//' + window.location.host;
        }
        return function (scope, element, attrs) {
            var mappedItems = null, allowCustomEntry = attrs.allowCustomEntry || false;
            var lastItem = null;
            var hiddenId = null;
            element.autocomplete({
                source: function (request, response) {
                    $http({
                        url: window.location.origin + '/archivefile/' + 'fighterautocomple',
                        method: 'GET',
                        params: { term: request.term }
                    })
                    .success(function (data) {
                        return response(data);
                    });

                },

                select: function (event, ui) {
                    console.log(scope);
                    angular.element(this).siblings().each(function(){
                        console.log(this);
                        if (angular.element(this).hasClass('fighter')) {
                            angular.element(this).val(ui.item.id);
                            hiddenId = this;
                            lastItem = ui.item.label;
                        }
                    });

                    scope.$apply(function (scope) {
                        modelAccessor.assign(scope, ui.item.value);
                    });

                    if (attrs.onSelect) {
                        scope.$apply(attrs.onSelect);
                    }

                    element.val(ui.item.label);

                    event.preventDefault();
                },

                change: function () {
                    var currentValue = element.val();
                    console.log(currentValue);
                    console.log(lastItem);
                    if (lastItem != currentValue) {
                        angular.element(hiddenId).val(null);
                    }
                }
            });
        };
    }
})
.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            console.log(element[0]);
            element.bind('change', function(){
                scope.$apply(function(){
                    console.log(element[0].files[0]);
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}])

.controller('IpmUploadCtrl', function($scope, $rootScope, $http){
    var uploadUrl = "/file-upload/ajaxupload";
    var ajaxfileremoveUrl = '/file-upload/ajaxfileremove'
    $scope.uploadInProgress = false;
    $scope.softRemove = false;
    var uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        fd.append('id', IPM_GLOBAL_ID);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function() {
            alert('die Datei ist fertig hochgeladen.');
            $scope.fileName = file.name;
            $scope.uploadInProgress = false;
        })
        .error(function() {
            $scope.uploadInProgress = false;
            alert('die Datei ist beim Hochladen fehlgeschlagen.');    
        });
    }
    
    $scope.uploadFile = function(){
        $scope.uploadInProgress = true;
        var file = $scope.myFile;
        console.log('file is ' + JSON.stringify(file));        
        uploadFileToUrl(file, uploadUrl);
    };
    
    $scope.removeFile = function(id){
        
        var fd = new FormData();
        fd.append('uploadFileId', id);
        fd.append('sendeFileId', IPM_GLOBAL_ID);
        $http.post(ajaxfileremoveUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function() {
            alert('die Datei ist gelöscht');
            $scope.softRemove = true;
        })
        .error(function() {
            alert('die Datei ist beim Löschen fehlgeschlagen.');    
        });
    };
    
})
.directive('validFile',function(){
  return {
    require:'ngModel',
    link:function(scope,el,attrs,ngModel){
      el.bind('change',function(){
        scope.$apply(function(){
          ngModel.$setViewValue(el.val());
          ngModel.$render();
        });
      });
    }
  }
});


$(function() {
    $(".fighterAuto").autocomplete({
        source: "fighterautocomple",
        minLength: 3,
        select: function( event, ui ) {
            $.each($(this).siblings(), function(index, el) {
                if ($(el).hasClass('fighter')) {
                    $(el).val(ui.item.id);
                }
            });
        },
        
    });
    
    $(".fighterAuto").change(function() {
        if ($(this).val() == '') {
            $.each($(this).siblings(), function(index, el) {
                if ($(el).hasClass('fighter')) {
                    $(el).val('');
                }
            });
        }
    });
    $(".ipm_datepicker").datepicker({
        dateFormat: "dd.mm.yy"
    });

});
