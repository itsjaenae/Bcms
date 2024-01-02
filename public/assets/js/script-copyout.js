var price = 0; //price
var $cart = $('#selected-seats'); //Sitting Area
var $counter = $('#counter'); //Votes
var $total = $('#total'); //Total money

var sc = $('#seat-map').seatCharts({
    map: [  //Seating chart
        'aaaaaaaaaa',
                'aaaaaaa__a',
                'aaaaaaaaaa',
                'aaaaaaaaaa',
        'aaaaaaabbb'
    ],
    naming : {
        top : true,
        rows: ['A','B','C','D','E'],
        getLabel : function (character, row, column) {
            return column;
        }
    },
    seats:{
        a:{
            price: 99.9
        },
        b:{
            price: 200
        }
    },
    legend : { //Definition legend
        node : $('#legend'),
        items : [
            [ 'a', 'available',   'Option' ],
            [ 'a', 'unavailable', 'Sold']
        ]
    },
    click: function () { //Click event
        if (this.status() == 'available') { //optional seat
            var maxSeats = 3;
            var ms = sc.find('selected').length;
            //alert(ms);
            if (ms < maxSeats) {

                price = this.settings.data.price;



                $('<option selected>R'+(this.settings.row+1)+' S'+this.settings.label+' P'+this.settings.data.price+'</option>')
                .attr('id', 'cart-item-'+this.settings.id)
                .attr('value', this.settings.id + "|" + this.settings.data.price)
                .attr('alt', price)
                .data('seatId', this.settings.id)
                .appendTo($cart);

                $counter.text(sc.find('selected').length+1);
                $counter.attr('value', sc.find('selected').length+1);

                $total.text(recalculateTotal(sc));
                $total.attr('value', recalculateTotal(sc));

                return 'selected';
            }
                alert('You can only choose '+ maxSeats + ' seats.');
                return 'available';

        } else if (this.status() == 'selected') { //Checked

                //Update Number
                $counter.text(sc.find('selected').length-1);
                $counter.attr('value', sc.find('selected').length-1);

                //Delete reservation
                $('#cart-item-'+this.settings.id).remove();

                //update totalnum
                $total.text(recalculateTotal(sc));
                $total.attr('value', recalculateTotal(sc));

                //Delete reservation
                  //$('#cart-item-'+this.settings.id).remove();
                //optional
                return 'available';

        } else if (this.status() == 'unavailable') { //sold
            return 'unavailable';

        } else {
            return this.style();
        }
    }
});
function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase

  number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''
  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }
  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }
  return s.join(dec)
}

// Add total money
function recalculateTotal(sc) {
    var total = 0;
    $('#selected-seats').find('option:selected').each(function () {
        total += Number($(this).attr('alt'));
    });

    return number_format(total,2,'.','');
}