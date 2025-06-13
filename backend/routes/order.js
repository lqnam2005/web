app.post('/api/order', (req, res) => {
  const { customer_name, phone, cart } = req.body;

  const insertOrder = `INSERT INTO orders (customer_name, phone) VALUES (?, ?)`;
  db.query(insertOrder, [customer_name, phone], (err, result) => {
    if (err) return res.status(500).send('❌ Lỗi lưu đơn hàng');

    const order_id = result.insertId;
    const orderItems = cart.map(item => [order_id, item.name, item.price, item.quantity, item.image]);

    const insertDetails = `INSERT INTO order_details (order_id, name, price, quantity, image) VALUES ?`;
    db.query(insertDetails, [orderItems], (err2) => {
      if (err2) return res.status(500).send('❌ Lỗi lưu chi tiết đơn hàng');

      // ✅ Thêm dòng này:
      res.send("✅ Đặt hàng thành công!");
    });
  });
});
