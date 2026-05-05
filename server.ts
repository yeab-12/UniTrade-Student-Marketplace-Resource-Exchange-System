import express from 'express';
import cors from 'cors';
import path from 'path';
import { createServer as createViteServer } from 'vite';

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());

// Mock Data
const categories = [
  { id: 1, key: 'electronics', label: 'Electronics', description: 'Laptops, phones, accessories', icon: 'Laptop' },
  { id: 2, key: 'stationery', label: 'Stationery', description: 'Books, pens, notebooks', icon: 'Book' },
  { id: 3, key: 'clothes', label: 'Clothes', description: 'Apparel, jackets, traditional wear', icon: 'Shirt' },
  { id: 4, key: 'shoes', label: 'Shoes', description: 'Sneakers, formals, sandals', icon: 'Footprints' },
  { id: 5, key: 'dorm', label: 'Dorm Essentials', description: 'Bedding, lamps, kitchenware', icon: 'Home' },
  { id: 6, key: 'food', label: 'Food & Beverage', description: 'Injera & wot, burgers, pasta, coffee', icon: 'Utensils' },
];

const items = [
  // Food & Beverage (10 items)
  { id: 1, title: 'በርገር ኮምቦ', category: 'Food & Beverage', categoryKey: 'food', price: 220, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=500', status: 'approved' },
  { id: 2, title: 'እንጀራ እና ወጥ', category: 'Food & Beverage', categoryKey: 'food', price: 150, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1626132647523-66f5bf380027?q=80&w=500', status: 'approved' },
  { id: 3, title: 'የመጠጥ ውሃ (10 ሊትር ጃር)', category: 'Food & Beverage', categoryKey: 'food', price: 120, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1623341214825-9f4f963727da?q=80&w=500', status: 'approved' },
  { id: 4, title: 'ኮካ ኮላ (1 ሊትር)', category: 'Food & Beverage', categoryKey: 'food', price: 80, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1554866585-cd94860890b7?q=80&w=500', status: 'approved' },
  { id: 5, title: 'ዶሮ ሳንድዊች', category: 'Food & Beverage', categoryKey: 'food', price: 130, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1521305916504-4a1121188589?q=80&w=500', status: 'approved' },
  { id: 6, title: 'ፍርፍር (Firfir)', category: 'Food & Beverage', categoryKey: 'food', price: 80, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1606471191009-63994c53433b?q=80&w=500', status: 'approved' },
  { id: 7, title: 'Pizza (Medium)', category: 'Food & Beverage', categoryKey: 'food', price: 450, condition: 'new', seller: 'Abebe T.', image: 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=500', status: 'approved' },
  { id: 8, title: 'Iced Coffee', category: 'Food & Beverage', categoryKey: 'food', price: 90, condition: 'new', seller: 'Sara K.', image: 'https://images.unsplash.com/photo-1517701550927-30cf4bb1dba5?q=80&w=500', status: 'approved' },
  { id: 9, title: 'Mango Juice (Fresh)', category: 'Food & Beverage', categoryKey: 'food', price: 70, condition: 'new', seller: 'Mulu B.', image: 'https://images.unsplash.com/photo-1546173159-315724a31696?q=80&w=500', status: 'approved' },
  { id: 10, title: 'Pastry Box (Mixed)', category: 'Food & Beverage', categoryKey: 'food', price: 180, condition: 'new', seller: 'Leyu D.', image: 'https://images.unsplash.com/photo-1550617931-e17a7b70dce2?q=80&w=500', status: 'approved' },

  // Electronics (10 items)
  { id: 11, title: 'Laptop Dell i5', category: 'Electronics', categoryKey: 'electronics', price: 18000, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?q=80&w=500', status: 'approved' },
  { id: 12, title: 'HP Laptop i3', category: 'Electronics', categoryKey: 'electronics', price: 12500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=500', status: 'approved' },
  { id: 13, title: 'Samsung Galaxy A12', category: 'Electronics', categoryKey: 'electronics', price: 6500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?q=80&w=500', status: 'approved' },
  { id: 14, title: 'iPhone 8 (64GB)', category: 'Electronics', categoryKey: 'electronics', price: 9000, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1510557880582-3d24297a3c80?q=80&w=500', status: 'approved' },
  { id: 15, title: 'Wireless Earbuds', category: 'Electronics', categoryKey: 'electronics', price: 800, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=500', status: 'approved' },
  { id: 16, title: 'Bluetooth Speaker', category: 'Electronics', categoryKey: 'electronics', price: 1200, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1608351489264-77b09b284c60?q=80&w=500', status: 'approved' },
  { id: 17, title: 'Laptop Charger Dell', category: 'Electronics', categoryKey: 'electronics', price: 500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1585338107529-13afc5f02586?q=80&w=500', status: 'approved' },
  { id: 18, title: 'Power Bank 10,000mAh', category: 'Electronics', categoryKey: 'electronics', price: 900, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1585822797334-03704944fa9a?q=80&w=500', status: 'approved' },
  { id: 19, title: 'USB Flash 32GB', category: 'Electronics', categoryKey: 'electronics', price: 250, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1531055458090-e37340059341?q=80&w=500', status: 'approved' },
  { id: 20, title: 'WiFi Router', category: 'Electronics', categoryKey: 'electronics', price: 1500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=500', status: 'approved' },

  // Stationery (10 items)
  // Stationery (10 items)
  { id: 21, title: 'Scientific Calculator', category: 'Stationery', categoryKey: 'stationery', price: 600, condition: 'used', seller: 'Yeabsira G.', image: 'data:image/jpeg;base64,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', status: 'approved' },
  { id: 22, title: 'Math Textbook Set', category: 'Stationery', categoryKey: 'stationery', price: 300, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1532012197267-da84d127e765?q=80&w=500', status: 'approved' },
  { id: 23, title: 'Notebook Pack (5 pcs)', category: 'Stationery', categoryKey: 'stationery', price: 200, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1533234458684-d8bc477e1f5d?q=80&w=500', status: 'approved' },
  { id: 24, title: 'Pens Bundle (10)', category: 'Stationery', categoryKey: 'stationery', price: 100, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1585336139118-132f8f9d5fdb?q=80&w=500', status: 'approved' },
  { id: 25, title: 'Backpack (Black)', category: 'Stationery', categoryKey: 'stationery', price: 850, condition: 'used', seller: 'Helen M.', image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=500', status: 'approved' },
  { id: 26, title: 'Geometry Set', category: 'Stationery', categoryKey: 'stationery', price: 150, condition: 'new', seller: 'Dawit L.', image: 'https://images.unsplash.com/photo-1516962215378-7fa2e1372cf5?q=80&w=500', status: 'approved' },
  { id: 27, title: 'Engineering Ruler', category: 'Stationery', categoryKey: 'stationery', price: 120, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1586075010620-227a17722904?q=80&w=500', status: 'approved' },
  { id: 28, title: 'A4 Paper Ream', category: 'Stationery', categoryKey: 'stationery', price: 400, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1589182337358-2cb63099350c?q=80&w=500', status: 'approved' },
  { id: 29, title: 'Graph Paper Book', category: 'Stationery', categoryKey: 'stationery', price: 80, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1586075010620-227a17722904?q=80&w=500', status: 'approved' },
  { id: 30, title: 'Study Lamp', category: 'Stationery', categoryKey: 'stationery', price: 350, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1534073828943-f801091bb18c?q=80&w=500', status: 'approved' },

  // Clothes (10 items)
  { id: 31, title: 'Hoodie Black', category: 'Clothes', categoryKey: 'clothes', price: 700, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=500', status: 'approved' },
  { id: 32, title: 'T-Shirt White', category: 'Clothes', categoryKey: 'clothes', price: 250, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=500', status: 'approved' },
  { id: 33, title: 'Jeans Pants', category: 'Clothes', categoryKey: 'clothes', price: 900, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=500', status: 'approved' },
  { id: 34, title: 'Jacket Winter', category: 'Clothes', categoryKey: 'clothes', price: 1500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=500', status: 'approved' },
  { id: 35, title: 'Traditional Shirt', category: 'Clothes', categoryKey: 'clothes', price: 800, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1556157382-97eda2d62296?q=80&w=500', status: 'approved' },
  { id: 36, title: 'Sweater Grey', category: 'Clothes', categoryKey: 'clothes', price: 600, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1556906781-9a412961c28c?q=80&w=500', status: 'approved' },
  { id: 37, title: 'Sports Wear Set', category: 'Clothes', categoryKey: 'clothes', price: 1000, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=500', status: 'approved' },
  { id: 38, title: 'Cap Hat', category: 'Clothes', categoryKey: 'clothes', price: 150, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1588850567047-1849a4445e90?q=80&w=500', status: 'approved' },
  { id: 39, title: 'Scarf Wool', category: 'Clothes', categoryKey: 'clothes', price: 200, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?q=80&w=500', status: 'approved' },
  { id: 40, title: 'Socks Pack', category: 'Clothes', categoryKey: 'clothes', price: 100, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1586350977771-b3b0ca50c685?q=80&w=500', status: 'approved' },

  // Shoes (10 items)
  { id: 41, title: 'Nike Running Shoes', category: 'Shoes', categoryKey: 'shoes', price: 2500, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=500', status: 'approved' },
  { id: 42, title: 'Adidas Sneakers', category: 'Shoes', categoryKey: 'shoes', price: 2800, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1587563871167-1ee9c731aefb?q=80&w=500', status: 'approved' },
  { id: 43, title: 'Formal Shoes Black', category: 'Shoes', categoryKey: 'shoes', price: 1200, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=500', status: 'approved' },
  { id: 44, title: 'Slippers Comfort', category: 'Shoes', categoryKey: 'shoes', price: 300, condition: 'new', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1603191659812-ee978eeeef76?q=80&w=500', status: 'approved' },
  { id: 45, title: 'Basketball Shoes', category: 'Shoes', categoryKey: 'shoes', price: 2000, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=500', status: 'approved' },
  { id: 46, title: 'Sandals Brown', category: 'Shoes', categoryKey: 'shoes', price: 400, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=500', status: 'approved' },
  { id: 47, title: 'High Top Shoes', category: 'Shoes', categoryKey: 'shoes', price: 1800, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=500', status: 'approved' },
  { id: 48, title: 'Canvas Shoes', category: 'Shoes', categoryKey: 'shoes', price: 900, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1518002171953-a080ee817e1f?q=80&w=500', status: 'approved' },
  { id: 49, title: 'School Shoes', category: 'Shoes', categoryKey: 'shoes', price: 700, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=500', status: 'approved' },
  { id: 50, title: 'Boots Winter', category: 'Shoes', categoryKey: 'shoes', price: 2200, condition: 'used', seller: 'Yeabsira G.', image: 'https://images.unsplash.com/photo-1608256246200-53e635b5b65f?q=80&w=500', status: 'approved' },
];

// API Routes
app.get('/api/categories', (req, res) => res.json(categories));
app.get('/api/items', (req, res) => {
  const { category, q } = req.query;
  let filtered = items.filter(i => i.status === 'approved');
  if (category) filtered = filtered.filter(i => i.categoryKey === category);
  if (q) filtered = filtered.filter(i => i.title.toLowerCase().includes((q as string).toLowerCase()));
  res.json(filtered);
});

async function startServer() {
  if (process.env.NODE_ENV !== 'production') {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: 'spa',
    });
    app.use(vite.middlewares);
  } else {
    const distPath = path.join(process.cwd(), 'dist');
    app.use(express.static(distPath));
    app.get('*', (req, res) => res.sendFile(path.join(distPath, 'index.html')));
  }

  app.listen(PORT, '0.0.0.0', () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer();
