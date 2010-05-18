
function convertDateToString(date) {
    var theYear = date.getFullYear().toString();
    var theMonth = (date.getMonth() + 1).toString();
    var theDay = date.getDate().toString();
    if (theMonth.length == 1) theMonth = '0' + theMonth;
    if (theDay.length == 1) theDay = '0' + theDay;
    return theYear + '-' + theMonth + '-' + theDay
}

function convertStringToDate(dateStr) {
    var theYear = parseInt(dateStr.substr(0, 4));
    var theMonth = parseInt(dateStr.substr(5, 2)) - 1;
    var theDay = parseInt(dateStr.substr(8, 2));
    var dateObj = new Date();
    dateObj.setFullYear(theYear, theMonth, theDay)
    return dateObj;
}

function setCurrentDate(calPicker, value) {
    calPicker.changeDate(convertStringToDate(value));
}