/*$(function () {
    "use strict";

    var pieData = document.getElementById('visitor').getAttribute('value');

    var chart = c3.generate({
        bindto: '#visitor',
        data: {
            columns: [
                [pieData]
            ],
            
            type : 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: {
            label: {
                show: false
            },
            title:"Submissions",
            width:20,
            
        },
        
        legend: {
        hide: true
        //or hide: 'data1'
        //or hide: ['data1', 'data2']
        },
        color: {
            pattern: ['#eceff1', '#24d2b5', '#6772e5', '#20aee3']
        }
    });



});*/