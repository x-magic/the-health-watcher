// A color list for bar charts
var colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'];
/**
 * Initialise first graph and bind event handlers to selectors
 */
function statisticsInit(){
    //Load chosen
    $(".chosen-select").chosen({allow_single_deselect:true,disable_search_threshold: 5});
    //Plot initial bar chart
    generateBar();
    //Bind event handler to selectors
    objSelectGender.on("change", updateBarGraph);
    objSelectAgeGroup.on("change", updateBarGraph);
    objSelectYear.on("change", updateBarGraph);
}
/**
 * Plot bar graph
 * This is the initializer
 */
function generateBar() {
    currentBarChart = plotBar(barData, barCategory, barCategoryID);
    plotAnchor = c3.generate(currentBarChart);
}
/**
 * Plot the bar graph
 *
 * @param data
 * @param category
 * @param categoryID This is just for requesting spline graph
 * @returns c3 plot configuration
 */
function plotBar(data, category, categoryID) {
    objPlotTitle.text('Number of admissions by conditions');
    return {
        data: {
            columns: [data],
            type: 'bar',
            onclick: function(d) {
                barGraphOnClickAjax(category[d.x], categoryID[d.x]);
            },
            labels: true,
            color: function (color, d) {
                return colors[d.index];
            },
        },
        axis: {
            x: {
                type: 'category',
                categories: category,
                //label: {
                //    text: "Click bar to reveal trend of condition by report years",
                //    position: 'outer-center',
                //},
                height: 40,
            },
            y: {
                show: false
            }
        },
        legend: { show: false },
    };
}
/**
 * Plot the spline graph
 *
 * @param data
 * @param category
 * @param title Title of disease
 * @returns c3 plot configuration
 */
function plotSpline(data, category, title) {
    objPlotTitle.text('Number of admissions of ' + title + ' by report year');
    return {
        data: {
            columns: data,
            type: 'spline',
            onclick: function(d) {
                objPlotTitle.text('Number of admissions by conditions');
                plotAnchor = c3.generate(currentBarChart);
                jQuery('#barDescription').show();
                jQuery('#splineDescription').hide();
                jQuery('#statistics-filter').animate({opacity: 'toggle', height: 'toggle'}, 200);
            },
            labels: true,
        },
        color: {
            pattern: ['green', 'blue', 'red'],
        },
        axis: {
            x: {
                type: 'category',
                categories: category,
                //label: {
                //    text: 'Click data point to go back to previous graph',
                //    position: 'outer-center',
                //},
                height: 40,
            },
            y: {
                show: false
            }
        },
        legend: { show: true },
    };
}
/**
 * Ajax error handler
 * Basically is force reload the page
 */
function ajaxLoadErrorHandler() {
    objPlotTitle.text("Error loading graph. Please refresh page");
    plotAnchor.unload({});
    alert("Error loading graph. Press OK to refresh page. ");
    location.reload();
}
/**
 * Ajax call and actions to plot spline graph
 * Activated when bar graph's bar is clicked
 *
 * @param title
 * @param categoryID
 */
function barGraphOnClickAjax(title, categoryID) {
    var postRequest = {requestDisease: categoryID};
    if (objSelectGender.val()) postRequest.requestGender = objSelectGender.val();
    if (objSelectAgeGroup.val()) postRequest.requestAgeGroup = objSelectAgeGroup.val();

    jQuery.ajax({
        url: ajaxSplineURL,
        type: 'POST',
        data: postRequest,
        beforeSend: function(){
            objPlotTitle.text('Graph is loading, thank you for your patience');
        },
        success: function(data) {
            plotAnchor = c3.generate(plotSpline(data.data, data.categories, title));
            jQuery('#barDescription').hide();
            jQuery('#splineDescription').show();
            jQuery('#statistics-filter').animate({opacity: 'toggle', height: 'toggle'}, 200);
        },
        error: ajaxLoadErrorHandler
    });
}
/**
 * Ajax call and actions to plot bar graph
 * Activated when selectors have changed
 */
function updateBarGraph() {
    var postRequest = {};
    //Get changed values
    if (objSelectGender.val()) postRequest.requestGender = objSelectGender.val();
    if (objSelectAgeGroup.val()) postRequest.requestAgeGroup = objSelectAgeGroup.val();
    if (objSelectYear.val()) postRequest.requestYear = objSelectYear.val();

    jQuery.ajax({
        url: ajaxBarURL,
        type: 'POST',
        data: postRequest,
        beforeSend: function(){
            objPlotTitle.text('Graph is loading, thank you for your patience');
        },
        success: function(data) {
            barData = data.data;
            barCategory = data.categories;
            barCategoryID = data.id;
            generateBar();
        },
        error: ajaxLoadErrorHandler
    });
}