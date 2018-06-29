// Define data set for overview tab charts
let overviewLabel = [20, 30, 15, 12, 21, 30, 20,30,35,30];
overviewData = {
    labels: ["Apr 19", "Apr 18","Apr 17","Apr 16","Apr 15","Apr 14","Apr 13","Apr 12","Apr 11","Apr 10",],
    datasets: [
        {
            label: "",
            fill: true,
            backgroundColor: 'rgba(230, 239, 245, 0.5)',
            borderColor: 'rgb(230, 239, 245)',
            data: overviewLabel,
        }]
};
let analysisLabel = [210, 230, 150, 120, 210, 190, 200,300,310,260];
analysisData = {
    labels: ["Apr 19", "Apr 18","Apr 17","Apr 16","Apr 15","Apr 14","Apr 13","Apr 12","Apr 11","Apr 10",],
    datasets: [
        {
            label: "",
            fill: true,
            backgroundColor: 'rgba(230, 239, 245, 0.5)',
            borderColor: 'rgb(230, 239, 245)',
            data: analysisLabel,
        }]
};
let marketsLabel = [2100, 2300, 1500, 1200, 2100, 1900, 2000,1000,3100,2100];
marketsData = {
    labels: ["Apr 19", "Apr 18","Apr 17","Apr 16","Apr 15","Apr 14","Apr 13","Apr 12","Apr 11","Apr 10",],
    datasets: [
        {
            label: "",
            fill: true,
            backgroundColor: 'rgba(230, 239, 245, 0.5)',
            borderColor: 'rgb(230, 239, 245)',
            data: marketsLabel,
        }]
};
let chartLabel = [21010, 20010, 15010, 12020, 21010, 19010, 20010,10010,31010,20010];
chartData = {
    labels: ["Apr 19", "Apr 18","Apr 17","Apr 16","Apr 15","Apr 14","Apr 13","Apr 12","Apr 11","Apr 10",],
    datasets: [
        {
            label: "",
            fill: true,
            backgroundColor: 'rgba(230, 239, 245, 0.5)',
            borderColor: 'rgb(230, 239, 245)',
            data: chartLabel,
        }]
};



createChart('overviewChart', overviewData);
createChart('analysisChart', analysisData);
createChart('marketChart', marketsData);
createChart('chartChart', chartData);

function createChart(id,data){
    var ctx = document.getElementById(id).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem) {
                        return tooltipItem.yLabel;
                    }
                }
            }
        }
    });

}
