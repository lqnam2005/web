const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const app = express();
const port = 5000;

app.use(cors());
app.use(express.json());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'food_app'
});

db.connect(err => {
  if (err) {
    console.error('❌ Lỗi kết nối CSDL:', err);
    return;
  }
  console.log('✅ Đã kết nối MySQL');
});

app.post('/api/order', (req, res) => {
  const { customer_name, phone, address, cart } = req.body;


  if (!cart || cart.length === 0) {
    return res.status(400).send("❌ Giỏ hàng rỗng");
  }

 const insertOrder = `INSERT INTO orders (customer_name, phone, address) VALUES (?, ?, ?)`;
db.query(insertOrder, [customer_name, phone, address], (err, result) => {

    if (err) return res.status(500).send('❌ Lỗi lưu đơn hàng');

    const order_id = result.insertId;
    const orderItems = cart.map(item => [order_id, item.name, item.price, item.quantity, item.image]);

    const insertDetails = `INSERT INTO order_details (order_id, name, price, quantity, image) VALUES ?`;
    db.query(insertDetails, [orderItems], (err2) => {
      if (err2) return res.status(500).send('❌ Lỗi lưu chi tiết đơn hàng');

      res.send("✅ Đặt hàng thành công!");
    });
  });
});

app.listen(port, () => {
  console.log(`🚀 Server chạy tại http://localhost:${port}`);
});
