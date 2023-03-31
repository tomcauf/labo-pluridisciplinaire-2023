const boxTraining = document.querySelector('.box-training'),
boxAccreditation = document.querySelector('.box-accreditation'),
boxOngoingTraining = document.querySelector('.box-ongoing-training'),
boxCompletedTraining = document.querySelector('.box-completed-training');

const boxTrainingBtn = document.querySelector('.box-training-btn'),
boxAccreditationBtn = document.querySelector('.box-accreditation-btn'),
boxOngoingTrainingBtn = document.querySelector('.box-ongoing-training-btn'),
boxCompletedTrainingBtn = document.querySelector('.box-completed-training-btn');

boxTrainingBtn.addEventListener('click', fullscreen(boxTraining, boxTrainingBtn));
boxAccreditationBtn.addEventListener('click', fullscreen(boxAccreditation, boxAccreditationBtn));
boxOngoingTrainingBtn.addEventListener('click', fullscreen(boxOngoingTraining, boxOngoingTrainingBtn));
boxCompletedTrainingBtn.addEventListener('click', fullscreen(boxCompletedTraining, boxCompletedTrainingBtn));

let fullscreen = function(box, boxBtn){
    let baseStyle = box.style;
    box.style = "position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;";
    boxBtn.src = "../assets/images/close_fullscreen.svg";
    boxBtn.addEventListener('click', function(){
        boxBtn.src = "../assets/images/open_fullscreen.svg";
        box.style = baseStyle;
    });
}
