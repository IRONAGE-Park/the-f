window.onload = function () {
  var imageId;
  var input = document.querySelector("#input");
  var inputProduct = document.querySelector('#input_product');
  //setup of initial table
  input.addEventListener("change", showFileMetadata, false);
  inputProduct.addEventListener("change", showProductFileMetadata, false);

  //loads file info into table
  function showFileMetadata() {
    var setup =
      "<table style='border: none; width: auto;'><tr><th>Image</th></tr>";
    var files = input.files;
    for (i = 0; i < files.length; i++) {
      imageId = "img" + i;
      setup +=
        '<tr><td id="' +
        imageId +
        '"></td>' +
        // '<td>' +
        // files[i].size +
        // " bytes </td>" +
        "</tr>";
    }
    setup += "</table>";
    document.querySelector("#table").innerHTML = setup;
    //completes table
    addThumbnail();
  }
  function showProductFileMetadata() {
    var setup =
      "<table style='border: none; width: auto;'><tr><th>Image</th><th>Name</th><th>Link</th></tr>";
    var files = inputProduct.files;
    for (i = 0; i < files.length; i++) {
      imageId = "img0" + i;
      setup +=
        "<tr>" + 
        // "<td>" +
        // files[i].name +
        //'</td>' +
        '<td id="' +
        imageId +
        '"></td>' +
        // '<td>' + files[i].size +
        // " bytes </td>" +
        "<td><input type='text' name='filename[]' size='15' require/></td>" +
        "<td><input type='text' name='filelink[]' size='15' require/></td>" +
        "</tr>";
    }
    setup += "</table>";
    document.querySelector("#tableProduct").innerHTML = setup;
    //completes table
    addProductThumbnail();
  }
  //update image sources
  function addThumbnail() {
    var files = input.files;
    for (var i = 0; i < files.length; i++) {
      imageId = "img" + i;
      var img = document.createElement("img");
      img.src = window.URL.createObjectURL(files[i]);

      img.height = 60;
      img.onload = function () {
        window.URL.revokeObjectURL(this.src);
      }
      document.getElementById(imageId).appendChild(img);
    }
  }
  function addProductThumbnail() {
    var files = inputProduct.files;
    for (var i = 0; i < files.length; i++) {
      imageId = "img0" + i;
      var img = document.createElement("img");
      img.src = window.URL.createObjectURL(files[i]);

      img.height = 60;
      img.onload = function () {
        window.URL.revokeObjectURL(this.src);
      }
      document.getElementById(imageId).appendChild(img);
    }
  }

};