const boxTraining = document.querySelector('.box-training'),
boxAccreditation = document.querySelector('.box-accreditation'),
boxOngoingTraining = document.querySelector('.box-ongoing-training'),
boxCompletedTraining = document.querySelector('.box-completed-training'),
boxManagement = document.querySelector('.box-management'),
boxAddUser = document.querySelector('.box-add-user'),
boxTrainingValidation = document.querySelector('.box-training-validation'),
boxRegisterManagement = document.querySelector('.box-register-management'),
boxListTraining = document.querySelector('.box-list-training'),
boxAddTraining = document.querySelector('.box-add-training'),
boxLogs = document.querySelector('.box-logs');

const boxTrainingBtn = document.querySelector('.box-training-btn'),
boxAccreditationBtn = document.querySelector('.box-accreditation-btn'),
boxOngoingTrainingBtn = document.querySelector('.box-ongoing-training-btn'),
boxCompletedTrainingBtn = document.querySelector('.box-completed-training-btn'),
boxManagementBtn = document.querySelector('.box-management-btn'),
boxAddUserBtn = document.querySelector('.box-add-user-btn'),
boxTrainingValidationBtn = document.querySelector('.box-training-validation-btn'),
boxRegisterManagementBtn = document.querySelector('.box-register-management-btn'),
boxListTrainingBtn = document.querySelector('.box-list-training-btn'),
boxAddTrainingBtn = document.querySelector('.box-add-training-btn'),
boxLogsBtn = document.querySelector('.box-logs-btn');


function toggleFullscreen(box, boxBtn) {
    let baseStyle = box.style;
    if (box.classList.contains('fullscreen')) {
        box.classList.remove('fullscreen');
        boxBtn.src = "../assets/images/open_fullscreen.svg";
        box.style = baseStyle;
    } else {
        box.classList.add('fullscreen');
        boxBtn.src = "../assets/images/close_fullscreen.svg";
        box.style = "position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;";
    }
}

if(boxTraining != null && boxTrainingBtn != null){
    boxTrainingBtn.addEventListener('click', function() {
        toggleFullscreen(boxTraining, boxTrainingBtn);
    });
}

if(boxAccreditation != null && boxAccreditationBtn != null){
    boxAccreditationBtn.addEventListener('click', function() {
        toggleFullscreen(boxAccreditation, boxAccreditationBtn);
    });
}

if(boxOngoingTraining != null && boxOngoingTrainingBtn != null){
    boxOngoingTrainingBtn.addEventListener('click', function() {
        toggleFullscreen(boxOngoingTraining, boxOngoingTrainingBtn);
    });
}

if(boxCompletedTraining != null && boxCompletedTrainingBtn != null){
    boxCompletedTrainingBtn.addEventListener('click', function() {
        toggleFullscreen(boxCompletedTraining, boxCompletedTrainingBtn);
    });
}
if(boxManagement != null && boxManagementBtn != null){
    boxManagementBtn.addEventListener('click', function() {
        toggleFullscreen(boxManagement, boxManagementBtn);
    });
}
if(boxAddUser != null && boxAddUserBtn != null){
    boxAddUserBtn.addEventListener('click', function() {
        toggleFullscreen(boxAddUser, boxAddUserBtn);
    });
}
if(boxTrainingValidation != null && boxTrainingValidationBtn != null){
    boxTrainingValidationBtn.addEventListener('click', function() {
        toggleFullscreen(boxTrainingValidation, boxTrainingValidationBtn);
    });
}
if(boxRegisterManagement != null && boxRegisterManagementBtn != null){
    boxRegisterManagementBtn.addEventListener('click', function() {
        toggleFullscreen(boxRegisterManagement, boxRegisterManagementBtn);
    });
}
if(boxListTraining != null && boxListTrainingBtn != null){
    boxListTrainingBtn.addEventListener('click', function() {
        toggleFullscreen(boxListTraining, boxListTrainingBtn);
    });
}
if(boxAddTraining != null && boxAddTrainingBtn != null){
    boxAddTrainingBtn.addEventListener('click', function() {
        toggleFullscreen(boxAddTraining, boxAddTrainingBtn);
    });
}
if(boxLogs != null && boxLogsBtn != null){
    boxLogsBtn.addEventListener('click', function() {
        toggleFullscreen(boxLogs, boxLogsBtn);
    });
}