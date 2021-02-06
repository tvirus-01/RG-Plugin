var demo = $("#demo").val();
var img_url = $("#img_url").val();
var itm_name = $("#itm_name").val();
var tk_price = $("#tk_price").val();
var declartion_text = $("#declartion_text").val();
var ticket_id = $("#ticket_id").val();
var percipient_limit = $("#percipient_limit").val();

var plugin_path = $("#chart").attr('plugin_path')+'../../';
var get_info_pat = plugin_path+'modules/getInfo.php';
var screen_width = $( window ).width();

// console.log(img_url);
if (screen_width <= 600) {
    var padding = {
        top: 20,
        right: 40,
        bottom: 0,
        left: 0
    },
    w = screen_width - padding.left - padding.right,
    h = screen_width - padding.top - padding.bottom,
    r = Math.min(w, h) / 2,
    rotation = 0,
    oldrotation = 0,
    picked = 100000,
    oldpick = [],
    color = d3.scale.category20();
}else{
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
    color = d3.scale.category20();
}           


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
console.log(data)

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
    .attr("class", function(d, i) {
        return data[i].value;
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
    .attr("id", function(d, i) {
        return data[i].value;
    })
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
    $("#purch_ticket_td").text("!Times UP");
    spin();
    $("#arrow").show();
    var countdown = document.getElementById("tiles");
    countdown.innerHTML = "<small>Times Up</small>"; 
},time_limit );

function spin(d) {
    console.log("spin start");

    if (demo == '1') {
        rg_chk_winner = 5;
    }else{    
        var rg_chk_winner = function(){
            var ret_data_w = 'nothing';
            
            $.ajax({
              'async': false,
              'global': false,  
              url: get_info_pat,
              type: 'post',
              data: {get_winner:"kk", t_id:ticket_id},
              success: function(data){
                ret_data_w = data;  
              },
            });
            return ret_data_w;
        }(); 
    }

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

    // console.log(data, rg_chk_winner);

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

        transform_winner = $("#"+rg_chk_winner).attr('transform');
        tw_sp1 = transform_winner.split(")")[0];
        winner_rotate = tw_sp1.split("(")[1];

        // random_deg = Math.floor(ma_rand * (slice_end - slice_start) + slice_start);
        rotation = -winner_rotate + rotation_deg;

        // console.log(random_deg, slice_start, slice_end, rotation, picked, slice_num);
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

    $("."+rg_chk_winner).addClass('glowing');
}
//make arrow
svg.append("g")
    .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h / 2) + padding.top) + ")")
    .append("path")
    .attr("d", "M-" + (r * .15) + ",0L0," + (r * .05) + "L0,-" + (r * .05) + "Z")
    .attr("id", "arrow")
    .style({
        "fill": "black",
        "display": "none"
    });
//draw spin circle
if (screen_width <= 600) {
    cr_r = screen_width * 0.25;
}else{
    cr_r = 150;
}
container.append("circle")
    .attr("cx", 0)
    .attr("cy", 0)
    .attr("r", cr_r)
    .style({
        "fill": "white"
});
//spin text
if (screen_width <= 600) {
    img_wh = screen_width * 0.33;
    img_cord = cr_r * 0.7;
}else{
    img_wh = 200;
    img_cord = 100;
}
container.append('image')
    .attr("x", -img_cord)
    .attr("y", -img_cord)
    .attr('xlink:href', img_url)
    .attr('width', img_wh)
    .attr('height', img_wh)

if (screen_width > 600) {
    container.append("text")
        .attr("x", 0)
        .attr("y", 120)
        .attr("text-anchor", "middle")
        .text(itm_name)
        .style({"font-weight":"bold", "font-size":"14px", "color":"royalblue"});
}else{
    container.append("text")
        .attr("x", 0)
        .attr("y", img_cord)
        .attr("text-anchor", "middle")
        .text(itm_name)
        .style({"font-weight":"bold", "font-size":"10px", "color":"royalblue"});
}


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

// var slice = document.querySelectorAll('.slice');
// for (var i=0; i<element.length; i+=1){
//     element[i].addEventListener('click', function(e) {
//         console.log(e);   
//     });
// }

// $(".slice").mouseover(function(e){
//     // var uname = $(this).text();
//     // $("#tooltip").html("<p><strong>"+uname+"</strong></p>");
//     // $("#tooltip").show();
//     console.log($(this));
// });
// $(".slice").mouseout(function(){
//     $("#tooltip").hide();
// });