//const canvas_graph_id = "influence_graphic";
//const nbr_values = 10;


function draw_influences(i, current_value, last_value)
{
	var graphic_canvas = document.getElementById("influence_graphic");
	var canvas = graphic_canvas.getContext("2d");
	var canvas_width = graphic_canvas.width;
	var canvas_height = graphic_canvas.height;


	var f_last_value = parseFloat(last_value);
	var f_current_value = parseFloat(current_value);
	var f_i = parseFloat(i)+1;

	canvas.moveTo(canvas_width / 10 * (f_i -1), (canvas_height / 50) * f_last_value);

	canvas.lineTo(canvas_width / 10 * f_i, (canvas_height / 50) * f_current_value);
	canvas.strokeStyle="#4e6891";
	canvas.shadowOffsetY=0;
	canvas.shadowOffsetX=0;
	canvas.shadowBlur=0;
	canvas.stroke();
}