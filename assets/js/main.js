var img_url = $("#img_url").val();
var itm_name = $("#itm_name").val();
var tk_price = $("#tk_price").val();
var declartion_text = $("#declartion_text").val();
var ticket_id = $("#ticket_id").val();
var percipient_limit = $("#percipient_limit").val();

var plugin_path = $("#chart").attr('plugin_path')+'../../';
var get_info_pat = plugin_path+'modules/getInfo.php'

// console.log(img_url);
var padding = {
        top: 20,
        right: 40,
        bottom: 0,
        left: 0
    },
    w = 600 - padding.left - padding.right,
    h = 600 - padding.top - padding.bottom,
    r = Math.min(w, h) / 2,
    rotation = 0,
    oldrotation = 0,
    picked = 100000,
    oldpick = [],
    color = d3.scale.category20(); //category20c()
//randomNumbers = getRandomNumbers();
//http://osric.com/bingo-card-generator/?title=HTML+and+CSS+BINGO!&words=padding%2Cfont-family%2Ccolor%2Cfont-weight%2Cfont-size%2Cbackground-color%2Cnesting%2Cbottom%2Csans-serif%2Cperiod%2Cpound+sign%2C%EF%B9%A4body%EF%B9%A5%2C%EF%B9%A4ul%EF%B9%A5%2C%EF%B9%A4h1%EF%B9%A5%2Cmargin%2C%3C++%3E%2C{+}%2C%EF%B9%A4p%EF%B9%A5%2C%EF%B9%A4!DOCTYPE+html%EF%B9%A5%2C%EF%B9%A4head%EF%B9%A5%2Ccolon%2C%EF%B9%A4style%EF%B9%A5%2C.html%2CHTML%2CCSS%2CJavaScript%2Cborder&freespace=true&freespaceValue=Web+Design+Master&freespaceRandom=false&width=5&height=5&number=35#results
var data = [];

var rg_user_data = function(){
    var ret_data = 'nothing';
    
    $.ajax({
      'async': false,
      'global': false,  
      url: get_info_pat,
      type: 'post',
      data: {get_usr_buy:"kk", t_id:ticket_id},
      success: function(data){
        var obj = $.parseJSON(data);
        ret_data = obj;
      },
    });
    return ret_data;
}();

len_obj = 0
for (var i in rg_user_data) {
    data.push({
        "label": rg_user_data[i].toUpperCase(),
        "value": i,
        "question": rg_user_data[i]
    });
    len_obj += 1;
}

if (len_obj == 0) {
     data.push({
        "label": "",
        "value": 1,
        "question": declartion_text 
    });
    itm_name = "NO PARTICIPANT YET";
}

// Define the div for the tooltip
var div = d3.select("body").append("div")   
    .attr("class", "tooltip")               
    .style("opacity", 0);

var svg = d3.select('#chart')
    .append("svg")
    .data([data])
    .attr("width", w + padding.left + padding.right)
    .attr("height", h + padding.top + padding.bottom);
var container = svg.append("g")
    .attr("class", "chartholder")
    .attr("transform", "translate(" + (w / 2 + padding.left) + "," + (h / 2 + padding.top) + ")");
var vis = container
    .append("g");

var pie = d3.layout.pie().sort(null).value(function(d) {
    return 1;
});
// declare an arc generator function
var arc = d3.svg.arc().outerRadius(r);
// select paths, use arc generator to draw
var arcs = vis.selectAll("g.slice")
    .data(pie)
    .enter()
    .append("g")
    .attr("class", "slice");

arcs.append("path")
    .attr("fill", function(d, i) {
        return color(i);
    })
    .attr("d", function(d) {
        return arc(d);
    });
// add the text
arcs.append("text").attr("transform", function(d) {
        d.innerRadius = 0;
        d.outerRadius = r;
        d.angle = (d.startAngle + d.endAngle) / 2;
        return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")translate(" + (d.outerRadius - 10) + ")";
    })
    .attr("text-anchor", "end")
    .attr("class", "label-txt")
    .text(function(d, i) {
        return data[i].label;
    });
// container.on("click", spin);
//countdown function
var minutes = $( '#set-time' ).val();

var target_date = new Date().getTime() + ((minutes * 60 ) * 1000); // set the countdown date
var time_limit = ((minutes * 60 ) * 1000);
// var time_limit = 5;
//set actual timer
setTimeout(function() {
    $("#question h4").hide();
    $("#purch_ticket").hide();
    $("#question h1").text('Ticket prchase time is over');
    $("#purch_ticket_td").text("!Times UP")
    spin();
    var countdown = document.getElementById("tiles");
    countdown.innerHTML = "<small>Times Up</small>"; 
},time_limit );

function spin(d) {

    var rg_chk_winner = function(){
        var ret_data_w = 'nothing';
        
        $.ajax({
          'async': false,
          'global': false,  
          url: get_info_pat,
          type: 'post',
          data: {get_winner:"kk", t_id:ticket_id},
          success: function(data){
            // console.log(data);
            ret_data_w = data;  
          },
        });
        return ret_data_w;
    }(); 

    container.on("click", null);
    //all slices have been seen, all done
    // console.log("OldPick: " + oldpick.length, "Data length: " + data.length);
    if (oldpick.length == data.length) {
        // console.log("done");
        container.on("click", null);
        return;
    }
    var ps = 360 / data.length,
        pieslice = Math.round(1440 / data.length),
        ma_rand = Math.random(),
        rng = Math.floor((ma_rand * 1440) + 360);

    console.log(data, rg_chk_winner);

    rotation_num = 4;
    rotation_deg = rotation_num * 360;

    if (rg_chk_winner == 'no_winner') {
        rotation = (Math.round(rng / ps) * ps);
        picked = Math.round(data.length - (rotation % 360) / ps);
        picked = picked >= data.length ? (picked % data.length) : picked;
        rotation += 90 - Math.round(ps / 2);

        winner_id = data[picked].value;
         $.ajax({
          url: get_info_pat,
          type: 'post',
          data: {set_winner:"kk", t_id:ticket_id, winner_id:winner_id},
          success: function(data){
            console.log(data);
            // ret_data_w = data;  
          },
        });

        console.log(winner_id);
    }else{
        deg_per_slice = 360/data.length;
        
        for(i in data){
            if (data[i]['value'] == rg_chk_winner) {
                data_ind = i;
            }
        }
        
        picked = data_ind;
        if (picked == 0) {
            slice_num = data.length - 1;
            slice_start = deg_per_slice * slice_num;
            slice_start += 2;
            slice_end = 360;
            slice_end -= 2;
        }else{
            slice_num = picked - 1;
            slice_start = deg_per_slice * slice_num;
            slice_start += 2;
            slice_end = deg_per_slice * picked;
            slice_end -= 2;
        }

        random_deg = Math.floor(ma_rand * (slice_end - slice_start) + slice_start);
        rotation = -random_deg + rotation_deg;

        console.log(random_deg, slice_start, slice_end, rotation);
    }
    
    if (oldpick.indexOf(picked) !== -1) {
        d3.select(this).call(spin);
        return;
    } else {
        oldpick.push(picked);
    }

    vis.transition()
        .duration(5000)
        .attrTween("transform", rotTween)
        .each("end", function() {
            //mark question as seen
            // d3.select(".slice:nth-child(" + (picked + 1) + ") path")
            //     .attr("fill", "#fff");
            //populate question
            d3.select("#question h1")
                .html(declartion_text+ "<br> <span class='glow'>"+data[picked].question+"<span>");
            oldrotation = rotation;

            /* Get the result value from object "data" */
            // console.log(data[picked].value)

            /* Comment the below line for restrict spin to sngle time */
            // container.on("click", spin);
        });
}
//make arrow
svg.append("g")
    .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h / 2) + padding.top) + ")")
    .append("path")
    .attr("d", "M-" + (r * .15) + ",0L0," + (r * .05) + "L0,-" + (r * .05) + "Z")
    .style({
        "fill": "black"
    });
//draw spin circle
container.append("circle")
    .attr("cx", 0)
    .attr("cy", 0)
    .attr("r", 150)
    .style({
        "fill": "white"
    });
//spin text
container.append('image')
    .attr("x", -100)
    .attr("y", -100)
    .attr('xlink:href', img_url)
    .attr('width', 200)
    .attr('height', 200)

container.append("text")
    .attr("x", 0)
    .attr("y", 120)
    .attr("text-anchor", "middle")
    .text(itm_name)
    .style({"font-weight":"bold", "font-size":"14px", "color":"royalblue"});


function rotTween(to) {
    var i = d3.interpolate(oldrotation % 360, rotation);
    return function(t) {
        return "rotate(" + i(t) + ")";
    };
}


function getRandomNumbers() {
    var array = new Uint16Array(1000);
    var scale = d3.scale.linear().range([360, 1440]).domain([0, 100000]);
    if (window.hasOwnProperty("crypto") && typeof window.crypto.getRandomValues === "function") {
        window.crypto.getRandomValues(array);
        console.log("works");
    } else {
        //no support for crypto, get crappy random numbers
        for (var i = 0; i < 1000; i++) {
            array[i] = Math.floor(Math.random() * 100000) + 1;
        }
    }
    return aarray;
}

var link = $("#buy_ticket").attr('link');
// console.log(link);

$("#buy_ticket").click(function() {
    window.location.href = link;
});

$(".slice").mouseover(function(){
    var uname = $(this).text();
    $("#tooltip").html("<p><strong>"+uname+"</strong></p>");
    $("#tooltip").show();
});
$(".slice").mouseout(function(){
    $("#tooltip").hide();
});