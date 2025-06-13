// const menuLeft = document.querySelectorAll(".admin-content-left > ul > li");

// menuLeft.forEach(function(menuItem, index) {
//     menuItem.addEventListener("click", function() {
//         menuItem.classList.toggle("active");
//     });
// });
  
  // Lấy tất cả nút "Đặt món"
  const buttons = document.querySelectorAll('.menu_btn');

  buttons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.preventDefault();  // Ngăn chặn chuyển trang

      // Lấy thông tin món ăn từ data attributes
      const name = this.getAttribute('data-name');
      const price = parseInt(this.getAttribute('data-price'));
      const image = this.getAttribute('data-image');

      // Lấy giỏ hàng hiện có từ localStorage hoặc tạo mới
      let cart = JSON.parse(localStorage.getItem('cart')) || [];

      // Kiểm tra món đã có chưa
      const existingItem = cart.find(item => item.name === name);
      if (existingItem) {
        existingItem.quantity += 1; // tăng số lượng nếu có rồi
      } else {
        cart.push({ name: name, price: price, image: image, quantity: 1 }); // thêm món mới
      }

      // Lưu lại localStorage
      localStorage.setItem('cart', JSON.stringify(cart));

      alert('Đã thêm "' + name + '" vào giỏ hàng!');
    });
  });



  document.getElementById("searchInput").addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    const cards = document.querySelectorAll(".menu_card");

    cards.forEach(card => {
      const title = card.querySelector("h2").textContent.toLowerCase();
      const desc = card.querySelector("p").textContent.toLowerCase();

      if (title.includes(keyword) || desc.includes(keyword)) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });

    

// Toggle món yêu thích khi nhấn vào trái tim trong mỗi món
const hearts = document.querySelectorAll(".menu_card .fa-heart");
hearts.forEach(heart => {
  heart.addEventListener("click", () => {
    const card = heart.closest(".menu_card");
    const name = card.querySelector("h2").textContent.trim();
    const price = parseInt(card.querySelector("h3").textContent);
    const image = card.querySelector("img").getAttribute("src");

    let favorites = JSON.parse(localStorage.getItem("favorites")) || [];
    const exists = favorites.find(item => item.name === name);

    if (exists) {
      favorites = favorites.filter(item => item.name !== name);
      heart.style.color = "gray";
    } else {
      favorites.push({ name, price, image });
      heart.style.color = "red";
    }
    localStorage.setItem("favorites", JSON.stringify(favorites));
  });
});

// Hiển thị danh sách yêu thích
function showFavorites() {
  const popup = document.getElementById("favorites-popup");
  const list = document.getElementById("favorites-list");
  const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
  list.innerHTML = "";

  if (favorites.length === 0) {
    list.innerHTML = "<li>Chưa có món yêu thích.</li>";
  } else {
    favorites.forEach(item => {
      const li = document.createElement("li");
      li.innerHTML = `
        <img src="${item.image}" width="40" style="vertical-align: middle; margin-right: 8px;">
        ${item.name} - ${item.price.toLocaleString()}đ
        <button onclick='addToCart(${JSON.stringify(item)})'>Thêm</button>
        <button onclick='removeFavorite("${item.name}")' style="margin-left: 5px;">❌ Xóa</button>
      `;
      list.appendChild(li);
    });
  }

  // Luôn giữ bảng hiện nếu đã mở
  popup.style.display = "block";
}


// Hàm thêm vào giỏ hàng từ danh sách yêu thích
function addToCart(item) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const exists = cart.find(i => i.name === item.name);
  if (exists) {
    exists.quantity += 1;
  } else {
    cart.push({ ...item, quantity: 1 });
  }
  localStorage.setItem("cart", JSON.stringify(cart));

  // SỬA LỖI: Thêm dòng alert này để thông báo cho người dùng
  alert('Đã thêm "' + item.name + '" vào giỏ hàng!');
}

function removeFavorite(name) {
  let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

  // Xoá món khỏi danh sách yêu thích
  favorites = favorites.filter(item => item.name !== name);

  // Lưu lại
  localStorage.setItem("favorites", JSON.stringify(favorites));

  // Cập nhật lại giao diện
  showFavorites();

  // Cập nhật màu trái tim (nếu đang hiển thị)
  const hearts = document.querySelectorAll(".menu_card .fa-heart");
  hearts.forEach(heart => {
    const card = heart.closest(".menu_card");
    const title = card.querySelector("h2").textContent.trim();
    if (title === name) {
      heart.style.color = "gray";
    }
  });
}