$(function() {
    "use strict";



var ctx = document.getElementById("dashboard-chart-trans").getContext('2d');
 


      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [ monthData11, monthData10, monthData9, monthData8, monthData7, monthData6, monthData5, monthData4, monthData3, monthData2,monthData1,monthData0 ],
          datasets: [{
            label: 'Transactions',
            data: [trantotal11,trantotal10,trantotal9,trantotal8,trantotal7,trantotal6,trantotal5, trantotal4, trantotal3, trantotal2, trantotal1,trantotal0],
            borderColor: '#2dce89',
            backgroundColor: '#2dce89',
            hoverBackgroundColor: '#2dce89',
            pointRadius: 0,
            fill: false,
            borderWidth: 1
          }  

          ]
        },
    options:{
      legend: {
        position: 'bottom',
              display: true,
        labels: {
                boxWidth:12
              }
            },  
      scales: {
        xAxes: [{
        stacked: true,
        barPercentage: .5
        }],
          yAxes: [{ 
            stacked: true
             }]
         },
      tooltips: {
        displayColors:false,
      }
    }
      });

   

 

   });	 
   