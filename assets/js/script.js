function tkt_search_on_the_fly_function() {
    var tkt_input, tkt_filter, tkt_ul, tkt_li, tkt_a, tkt_i, tkt_txtValue;
    tkt_input = document.getElementById("tkt-search-input");
    tkt_filter = tkt_input.value.toUpperCase();
    tkt_ul = document.getElementsByClassName("tkt-searchable-contents");
    for (let tkt_item of tkt_ul) {
      tkt_li = tkt_item.getElementsByTagName("li");
      for (tkt_i = 0; tkt_i < tkt_li.length; tkt_i++) {
        tkt_a = tkt_li[tkt_i].getElementsByTagName("a")[0];
        tkt_txtValue = tkt_a.textContent || tkt_a.innerText;
        if (tkt_txtValue.toUpperCase().indexOf(tkt_filter) > -1) {
          tkt_li[tkt_i].style.display = "";
        } else {
          tkt_li[tkt_i].style.display = "none";
        }
      }
    }
}

var tkt_coll = document.getElementsByClassName("tkt_tree_view_parent_item");
var i;

for (i = 0; i < tkt_coll.length; i++) {
  tkt_coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "none") {
      content.style.display = "block";
    } else {
      content.style.display = "none";
    }
  });
}
