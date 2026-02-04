document.addEventListener('DOMContentLoaded', function () {
    let productSearchInput = document.getElementById('product_search');
    let warehouseDropDown = document.getElementById('warehouse_id');
    let productList = document.getElementById('product_list');
    let warehouseError = document.getElementById('warehouse_error');
    let orderItemsTableBody = document.querySelector('tbody');

    productSearchInput.addEventListener('keyup', function () {
        let query = this.value;
        let warehouseId = warehouseDropDown.value;

        if (!warehouseId) {
            warehouseError.classList.remove('d-none');
            productList.innerHTML = "";
            return
        } else {
            warehouseError.classList.add('d-none');
        }

        if (query.length) {
            fetchProduct(query, warehouseId);
        } else {
            productList.innerHTML = "";
        }
    })


    function fetchProduct(query, warehouseId) {
        fetch(productSearchUrl + `?q=${query}&warehouse_id=${warehouseId}`)
            .then((res) => res.json())
            .then(data => {
                productList.innerHTML = "";
                if (data.length) {
                    data.forEach(product => {
                        let item = `<a href="#" class="list-group-item list-group-item-action product-item"

                                        data-id="${product.id}"
                                        data-code="${product.code}"
                                        data-name="${product.name}"
                                        data-cost="${product.price}"
                                        data-stock="${product.quantity}"
                                        ><i class="mdi mdi-text-search me-2">${product.code} - ${product.name}</i></a>`;
                        productList.innerHTML += item;
                    })

                    document.querySelectorAll('.product-item').forEach(item => {
                        item.addEventListener("click", function (e) {
                            e.preventDefault();
                            // add to table
                            addProduct(this);
                        })
                    })
                } else {
                    productList.innerHTML = "<p class='text-muted'>No Product Found</p>"
                }
            })
    }

    function addProduct(productElement) {
        let productId = productElement.getAttribute("data-id");
        let productCode = productElement.getAttribute("data-code");
        let productName = productElement.getAttribute("data-name");
        let unitCost = parseFloat(productElement.getAttribute('data-cost'));
        let stock = parseInt(productElement.getAttribute('data-stock'));

        if (document.querySelector(`tr[data-id="${productId}"]`)) {
            toastr.warning("Item already added");
            return;
        }

        let row = `
              <tr data-id="${productId}">
                  <td>
                      ${productCode} - ${productName}
                      <button type="button" class="btn btn-primary btn-sm edit-discount-btn"
                          data-id="${productId}"
                          data-name="${productName}"
                          data-cost="${unitCost}"
                          data-bs-toggle="modal">
                          <span class="mdi mdi-book-edit "></span>
                      </button>
                      <input type="hidden" name="products[${productId}][id]" value="${productId}">
                      <input type="hidden" name="products[${productId}][name]" value="${productName}">
                      <input type="hidden" name="products[${productId}][code]" value="${productCode}">
                  </td>
                  <td>${unitCost.toFixed(2)}
                      <input type="hidden" name="products[${productId}][cost]" value="${unitCost}">
                  </td>
                  <td style="color:#ffc121">${stock}</td>
                  <td>
                      <div class="input-group">
                          <button class="btn btn-outline-secondary decrement-qty" type="button">−</button>
                          <input type="text" class="form-control text-center qty-input"
                              name="products[${productId}][quantity]" value="1" min="1" max="${stock}"
                              data-cost="${unitCost}" style="width: 30px;">
                          <button class="btn btn-outline-secondary increment-qty" type="button">+</button>
                      </div>
                  </td>
                  <td>
                      <input type="number" class="form-control discount-input"
                          name="products[${productId}][discount]" value="0" min="0" style="width:100px">
                  </td>
                  <td class="subtotal">${unitCost.toFixed(2)}</td>
                  <td><button class="btn btn-danger btn-sm remove-product"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
              </tr>
          `;

        orderItemsTableBody.innerHTML += row;
        productList.innerHTML = "";
        productSearchInput.value = "";

        updateEvent();
        updateTotal();
    }

    function updateEvent() {
        document.querySelectorAll(".qty-input, .discount-input").forEach(input => {
            input.addEventListener("input", function () {
                let row = this.closest("tr");
                let qty = parseInt(row.querySelector(".qty-input").value) || 1;
                let unitCost = parseFloat(row.querySelector(".qty-input").getAttribute("data-cost")) || 0;
                let discount = parseFloat(row.querySelector(".discount-input").value) || 0;

                let subtotal = (unitCost * qty) - discount;
                row.querySelector(".subtotal").textContent = subtotal.toFixed(2);

                updateTotal();
            });
        });

        document.querySelectorAll(".decrement-qty").forEach(button => {
            button.addEventListener('click', function () {
                let input = this.closest('.input-group').querySelector('.qty-input');
                let min = parseInt(input.getAttribute("min"));
                let value = parseInt(input.value);
                if (value > min) {
                    input.value = value - 1;
                    updateSubtotal(this.closest('tr'));
                }
            })
        })

        document.querySelectorAll(".increment-qty").forEach(button => {
            button.addEventListener('click', function () {
                let input = this.closest('.input-group').querySelector('.qty-input');
                let max = parseInt(input.getAttribute("max"));
                let value = parseInt(input.value);
                if (value < max) {
                    input.value = value + 1;
                    updateSubtotal(this.closest('tr'));
                }
            })
        })

        document.querySelectorAll(".remove-product").forEach(button => {
            button.addEventListener("click", function () {
                this.closest("tr").remove();
                updateTotal();
            });
        });


        document.getElementById('inputDiscount').addEventListener('input', function () {
            updateTotal();
        })

        document.getElementById('inputShipping').addEventListener('input', function () {
            updateTotal();
        })
    }



    function updateSubtotal(row) {
        let qty = parseFloat(row.querySelector(".qty-input").value);
        let discount = parseFloat(row.querySelector(".discount-input").value) || 0;
        let netUnitCost = parseFloat(row.querySelector(".qty-input").dataset.cost);

        // Calculate subtotal after discount
        let subtotal = (netUnitCost * qty) - discount;
        row.querySelector(".subtotal").innerText = subtotal.toFixed(2);

        // Update Total
        updateTotal();
    }


    function updateTotal() {
        let total = 0;

        document.querySelectorAll(".subtotal").forEach(function (item) {
            total += parseFloat(item.textContent) || 0;
        });

        let discount = parseFloat(document.getElementById("inputDiscount").value) || 0;
        let shipping = parseFloat(document.getElementById("inputShipping").value) || 0;

        total = total - discount + shipping;

        if (total < 0) {
            total = 0;
        }


        document.getElementById('displayDiscount').textContent = `TK ${discount.toFixed(2)}`;
        if (discount > 0) {
            document.getElementById('displayDiscount').classList.add(`text-danger`);
        } else {
            document.getElementById('displayDiscount').classList.remove(`text-danger`);
        }


        document.getElementById('shippingDisplay').textContent = `TK ${shipping.toFixed(2)}`;
        document.getElementById('total').textContent = `TK ${total.toFixed(2)}`;
        document.querySelector("input[name='total']").value = total.toFixed(2);

    }


    //  Modal
    let modal = document.createElement('div');
    modal.id = "customModal";
    modal.style.position = "fixed";
    modal.style.top = "0";
    modal.style.left = "0";
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    modal.style.display = "none";
    modal.style.justifyContent = "center";
    modal.style.alignItems = "center";
    modal.style.zIndex = "1000";

    modal.innerHTML = `
      <div style="background: white; padding: 20px; border-radius: 5px; width: 400px;">
          <h3 id="modalTitle"></h3>
          <label>Product Price: <span class="text-danger">*</span></label>
          <input type="number" id="modalPrice" class="form-control mb-3" />

          <label>Discount Type: <span class="text-danger">*</span></label>
          <select id="modalDiscountType" class="form-control mb-3">
              <option value="">Select Discount</option>
              <option value="fixed">Fixed</option>
              <option value="percentage">Percentage</option>
          </select>

          <label>Discount: <span class="text-danger">*</span></label>
          <input type="number" id="modalDiscount" class="form-control mb-3" value="0" />

          <div style="margin-top: 15px; text-align: right;">
              <button id="closeModal" class="btn btn-secondary">Close</button>
              <button id="saveChanges" class="btn btn-primary">Save Changes</button>
          </div>
      </div>
  `;

    document.body.appendChild(modal);

    document.addEventListener("click", function (event) {
        if (event.target.closest(".edit-discount-btn")) {
            let button = event.target.closest(".edit-discount-btn");
            let productId = button.getAttribute("data-id");
            let productName = button.getAttribute("data-name");
            let productPrice = button.getAttribute("data-cost");

            // Set modal values
            document.getElementById("modalTitle").innerText = productName;
            document.getElementById("modalPrice").value =productPrice;
            modal.setAttribute("data-id", productId); // Store productId in modal

            // Show modal
            modal.style.display = "flex";
        }
    });

    // Close Modal
    document.getElementById("closeModal").addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Save
    document.getElementById('saveChanges').addEventListener('click', function () {
        let updatedPrice = parseFloat(document.getElementById('modalPrice').value);
        let discountValue = parseFloat(document.getElementById('modalDiscount').value) || 0;
        let discountType = document.getElementById("modalDiscountType").value;
        let productId = modal.getAttribute("data-id");
        let row = document.querySelector(`tr[data-id="${productId}"]`);

        if (row) {
            let priceCell = row.querySelector("td:nth-child(2)");
            let qtyInput = row.querySelector(".qty-input");
            let discountInput = row.querySelector(".discount-input");
            let subtotalCell = row.querySelector(".subtotal");

            // Update price in table
            priceCell.innerText = updatedPrice.toFixed(2);
            qtyInput.setAttribute("data-cost", updatedPrice);

            // Set discount value
            discountInput.value = discountValue.toFixed(2);

            // Apply discount calculation
            let qty = parseFloat(qtyInput.value);
            let discountAmount = discountType === "percentage" ? (updatedPrice * qty * (discountValue / 100)) : discountValue;
            let subtotal = (updatedPrice * qty) - discountAmount;

            subtotalCell.innerText = subtotal.toFixed(2);

            modal.style.display = "none";
            updateTotal();
        }
    })
})
