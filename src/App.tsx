import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Link, useLocation } from 'react-router-dom';
import { 
  Laptop, Book, Shirt, Footprints, Home as HomeIcon, Utensils, 
  Search, CheckCircle2, CloudUpload, ShieldCheck, Send, Menu, X, 
  ChevronRight, ArrowRight, User, LogOut, LayoutDashboard, Settings
} from 'lucide-react';
import { motion, AnimatePresence } from 'motion/react';
import { cn } from './lib/utils';

// Types
interface Item {
  id: number;
  title: string;
  category: string;
  categoryKey: string;
  price: number;
  condition: 'new' | 'used';
  seller: string;
  image: string;
  status: string;
}

// Components
const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const location = useLocation();

  return (
    <nav className="sticky top-0 z-50 bg-white border-b border-gray-100">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16 items-center">
          <div className="flex items-center">
            <Link to="/" className="text-2xl font-bold text-blue-900">UniTrade</Link>
          </div>
          
          <div className="hidden md:flex items-center space-x-8">
            <Link to="/" className={cn("text-gray-600 hover:text-blue-900 font-medium", location.pathname === '/' && "text-blue-900")}>Home</Link>
            <Link to="/marketplace" className={cn("text-gray-600 hover:text-blue-900 font-medium", location.pathname === '/marketplace' && "text-blue-900")}>Marketplace</Link>
            <Link to="/sell" className={cn("text-gray-600 hover:text-blue-900 font-medium", location.pathname === '/sell' && "text-blue-900")}>Sell</Link>
            <Link to="/contact" className={cn("text-gray-600 hover:text-blue-900 font-medium", location.pathname === '/contact' && "text-blue-900")}>Contact</Link>
          </div>

          <div className="hidden md:flex items-center space-x-4">
            <Link to="/login" className="text-blue-900 font-medium px-4 py-2">Login</Link>
            <Link to="/signup" className="bg-blue-900 text-white font-medium px-6 py-2 rounded-lg hover:bg-blue-800 transition-colors">Join UniTrade</Link>
          </div>

            <div className="md:hidden">
              <button onClick={() => setIsOpen(!isOpen)} className="text-gray-600 p-2">
                {isOpen ? <X /> : <Menu />}
              </button>
            </div>
          </div>
        </div>

      {/* Mobile Menu */}
      <AnimatePresence>
        {isOpen && (
          <motion.div 
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            className="md:hidden bg-white border-t border-gray-100 overflow-hidden"
          >
            <div className="px-4 py-6 space-y-4">
              <Link to="/" className="block text-gray-600 font-medium">Home</Link>
              <Link to="/marketplace" className="block text-gray-600 font-medium">Marketplace</Link>
              <Link to="/sell" className="block text-gray-600 font-medium">Sell</Link>
              <Link to="/contact" className="block text-gray-600 font-medium">Contact</Link>
              <div className="pt-4 border-t border-gray-100 flex flex-col space-y-4">
                <Link to="/login" className="text-blue-900 font-medium py-2">Login</Link>
                <Link to="/signup" className="bg-blue-900 text-white font-medium px-6 py-3 rounded-lg text-center">Join UniTrade</Link>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </nav>
  );
};

const Footer = () => (
  <footer className="bg-white border-t border-gray-100 pt-16 pb-8">
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div className="grid grid-cols-1 md:grid-cols-4 gap-12">
        <div className="md:col-span-2">
          <h2 className="text-2xl font-bold text-blue-900 mb-4">UniTrade</h2>
          <p className="text-gray-500 max-w-sm">
            The trusted student marketplace for Adama Science and Technology University. 
            Buy, sell, and exchange items safely — verified students only.
          </p>
        </div>
        <div>
          <h3 className="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Explore</h3>
          <ul className="space-y-3">
            <li><Link to="/marketplace" className="text-gray-500 hover:text-blue-900 transition-colors">Marketplace</Link></li>
            <li><Link to="/sell" className="text-gray-500 hover:text-blue-900 transition-colors">Sell an item</Link></li>
            <li><Link to="/contact" className="text-gray-500 hover:text-blue-900 transition-colors">Contact</Link></li>
          </ul>
        </div>
        <div>
          <h3 className="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider">Account</h3>
          <ul className="space-y-3">
            <li><Link to="/signup" className="text-gray-500 hover:text-blue-900 transition-colors">Sign up</Link></li>
            <li><Link to="/login" className="text-gray-500 hover:text-blue-900 transition-colors">Login</Link></li>
            <li><Link to="/dashboard" className="text-gray-500 hover:text-blue-900 transition-colors">My dashboard</Link></li>
          </ul>
        </div>
      </div>
      <div className="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
        <p>© 2026 UniTrade · Built for ASTU students</p>
        <div className="flex space-x-6">
          <a href="#" className="hover:text-blue-900">Privacy Policy</a>
          <a href="#" className="hover:text-blue-900">Community Rules</a>
        </div>
      </div>
    </div>
  </footer>
);

const CategoryCard = ({ icon: Icon, label, description, link }: any) => (
  <Link to={link} className="block group">
    <div className="bg-white p-6 rounded-2xl border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 text-center h-full">
      <div className="w-16 h-16 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center mx-auto mb-4 transition-colors group-hover:bg-blue-900 group-hover:text-white">
        <Icon size={32} />
      </div>
      <h3 className="font-bold text-gray-900 mb-1">{label}</h3>
      <p className="text-xs text-gray-400">{description}</p>
    </div>
  </Link>
);

const ItemCard = ({ item }: any) => (
  <motion.div 
    whileHover={{ y: -5 }}
    className="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full"
  >
    <div className="relative aspect-square overflow-hidden bg-gray-100">
      <img src={item.image} alt={item.title} className="w-full h-full object-cover" />
      <span className={cn(
        "absolute top-3 left-3 px-2 py-1 text-[10px] uppercase font-bold tracking-wider rounded-md",
        item.condition === 'new' ? "bg-green-100 text-green-700" : "bg-orange-100 text-orange-700"
      )}>
        {item.condition}
      </span>
    </div>
    <div className="p-4 flex flex-col flex-grow">
      <p className="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-1">{item.category}</p>
      <h3 className="font-bold text-gray-900 mb-3 line-clamp-1 h-6">{item.title}</h3>
      <div className="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
        <span className="text-lg font-bold text-blue-900">ETB {item.price.toLocaleString()}</span>
        <span className="text-xs text-gray-400">{item.seller}</span>
      </div>
    </div>
  </motion.div>
);

// Pages
const Home = () => {
  const [featured, setFeatured] = useState<Item[]>([]);

  useEffect(() => {
    fetch('/api/items?limit=8')
      .then(res => res.json())
      .then(data => setFeatured(data));
  }, []);

  return (
    <div className="flex flex-col">
      {/* Hero Section */}
      <section className="relative pt-20 pb-32 overflow-hidden bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 relative z-10">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div>
              <motion.div 
                initial={{ opacity: 0, x: -20 }}
                animate={{ opacity: 1, x: 0 }}
                className="inline-flex items-center space-x-2 bg-blue-100/50 text-blue-900 px-4 py-2 rounded-full text-sm font-semibold mb-8"
              >
                <span>Built for ASTU students</span>
              </motion.div>
              <motion.h1 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.1 }}
                className="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-[1.1] mb-8"
              >
                The student marketplace for <span className="text-blue-900">Adama Science & Tech</span>
              </motion.h1>
              <motion.p 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.2 }}
                className="text-xl text-gray-500 mb-10 max-w-lg leading-relaxed"
              >
                Buy, sell and exchange electronics, books, clothes and dorm essentials with verified students — priced in Ethiopian Birr, delivered through Telegram.
              </motion.p>
              
              <motion.div 
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: 0.3 }}
                className="flex flex-col sm:flex-row gap-4 mb-10"
              >
                <Link to="/marketplace" className="bg-blue-900 text-white text-lg font-bold px-10 py-5 rounded-2xl hover:bg-blue-800 transition-all flex items-center justify-center gap-2 group shadow-lg shadow-blue-900/20">
                  Browse marketplace
                  <ChevronRight size={20} className="group-hover:translate-x-1 transition-transform" />
                </Link>
                <Link to="/sell" className="bg-white text-gray-900 text-lg font-bold px-10 py-5 rounded-2xl hover:bg-gray-50 border border-gray-200 transition-all text-center">
                  Sell an item
                </Link>
              </motion.div>

              <div className="flex items-center space-x-2 text-gray-400 font-medium">
                <CheckCircle2 size={18} className="text-green-500" />
                <span>Verified students only — UGR ID + ASTU email required</span>
              </div>
            </div>
            <motion.div 
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: 0.4 }}
              className="relative d-none lg:block"
            >
              <div className="absolute -inset-4 bg-blue-900/10 rounded-[3rem] blur-3xl" />
              <img 
                src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1200&auto=format&fit=crop" 
                alt="ASTU Students" 
                className="relative rounded-[2.5rem] shadow-2xl w-full h-[600px] object-cover"
              />
            </motion.div>
          </div>
        </div>
      </section>

      {/* Categories */}
      <section className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold text-gray-900 mb-4">Browse by category</h2>
            <p className="text-lg text-gray-500">Find exactly what you need on campus.</p>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <CategoryCard icon={Laptop} label="Electronics" description="Laptops, phones, accessories" link="/marketplace?category=electronics" />
            <CategoryCard icon={Book} label="Stationery" description="Books, pens, notebooks" link="/marketplace?category=stationery" />
            <CategoryCard icon={Shirt} label="Clothes" description="Apparel, jackets, basics" link="/marketplace?category=clothes" />
            <CategoryCard icon={Footprints} label="Shoes" description="Sneakers, boots, sandals" link="/marketplace?category=shoes" />
            <CategoryCard icon={Utensils} label="Food & Beverage" description="Injera, burgers, coffee" link="/marketplace?category=food" />
          </div>
        </div>
      </section>

      {/* Featured Items */}
      <section className="py-24 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex justify-between items-end mb-12">
            <div>
              <h2 className="text-4xl font-bold text-gray-900 mb-4">Featured items</h2>
              <p className="text-lg text-gray-500">Newly approved by our admin team.</p>
            </div>
            <Link to="/marketplace" className="text-blue-900 font-bold hover:underline inline-flex items-center">
              See all <ArrowRight size={18} className="ml-1" />
            </Link>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {featured.map(item => (
              <ItemCard key={item.id} item={item} />
            ))}
          </div>
        </div>
      </section>

      {/* How it works */}
      <section className="py-24 bg-blue-950 text-white">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-20">
            <h2 className="text-4xl font-bold mb-4">How UniTrade works</h2>
            <p className="text-xl text-blue-200">Three simple steps from listing to sale.</p>
          </div>
          <div className="grid md:grid-cols-3 gap-16">
            <div className="text-center">
              <div className="w-20 h-20 bg-blue-900/50 text-blue-400 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-blue-800">
                <CloudUpload size={40} />
              </div>
              <h3 className="text-2xl font-bold mb-4">Upload your item</h3>
              <p className="text-blue-200 leading-relaxed">
                Snap a photo, add a price in ETB, write a quick description and submit.
              </p>
            </div>
            <div className="text-center">
              <div className="w-20 h-20 bg-blue-900/50 text-blue-400 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-blue-800">
                <ShieldCheck size={40} />
              </div>
              <h3 className="text-2xl font-bold mb-4">Admin approval</h3>
              <p className="text-blue-200 leading-relaxed">
                Our team reviews each listing to keep UniTrade safe and trustworthy.
              </p>
            </div>
            <div className="text-center">
              <div className="w-20 h-20 bg-blue-900/50 text-blue-400 rounded-3xl flex items-center justify-center mx-auto mb-8 border border-blue-800">
                <Send size={40} />
              </div>
              <h3 className="text-2xl font-bold mb-4">Sell via Telegram</h3>
              <p className="text-blue-200 leading-relaxed">
                Buyers contact you directly on Telegram. Meet on campus, exchange, done.
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

const Marketplace = () => {
  const [items, setItems] = useState<Item[]>([]);
  const [loading, setLoading] = useState(true);
  const location = useLocation();
  const searchParams = new URLSearchParams(location.search);
  const categoryFilter = searchParams.get('category');

  useEffect(() => {
    let url = '/api/items';
    if (categoryFilter) url += `?category=${categoryFilter}`;
    
    fetch(url)
      .then(res => res.json())
      .then(data => {
        setItems(data);
        setLoading(false);
      });
  }, [categoryFilter]);

  return (
    <div className="min-h-screen bg-white">
      <header className="bg-slate-50 py-16 border-b border-gray-100">
        <div className="max-w-7xl mx-auto px-4">
          <h1 className="text-4xl font-bold text-gray-900 mb-4">Marketplace</h1>
          <p className="text-lg text-gray-500">All listings are reviewed by our admin team before appearing here.</p>
        </div>
      </header>

      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid lg:grid-cols-4 gap-12">
          {/* Filters */}
          <div className="space-y-8">
            <div className="bg-slate-50 p-6 rounded-2xl space-y-6">
              <h3 className="font-bold text-gray-900">Filters</h3>
              
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">Search</label>
                <div className="relative">
                  <Search size={18} className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                  <input type="text" placeholder="Search..." className="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 outline-none transition-all" />
                </div>
              </div>

              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">Category</label>
                <select className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 outline-none transition-all">
                  <option value="">All categories</option>
                  <option value="electronics">Electronics</option>
                  <option value="stationery">Stationery</option>
                  <option value="clothes">Clothes</option>
                  <option value="shoes">Shoes</option>
                  <option value="dorm">Dorm Essentials</option>
                  <option value="food">Food & Beverage</option>
                </select>
              </div>

              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">Condition</label>
                <div className="space-y-2">
                  <label className="flex items-center space-x-2 text-sm text-gray-600">
                    <input type="checkbox" className="w-4 h-4 rounded border-gray-300 text-blue-900 focus:ring-blue-900" />
                    <span>New</span>
                  </label>
                  <label className="flex items-center space-x-2 text-sm text-gray-600">
                    <input type="checkbox" className="w-4 h-4 rounded border-gray-300 text-blue-900 focus:ring-blue-900" />
                    <span>Used</span>
                  </label>
                </div>
              </div>

              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">Price (ETB)</label>
                <div className="flex gap-2">
                  <input type="number" placeholder="Min" className="w-1/2 px-4 py-3 bg-white border border-gray-200 rounded-xl outline-none text-sm" />
                  <input type="number" placeholder="Max" className="w-1/2 px-4 py-3 bg-white border border-gray-200 rounded-xl outline-none text-sm" />
                </div>
              </div>

              <button className="w-full py-3 text-blue-900 font-bold hover:bg-white transition-colors rounded-xl border border-blue-900/10">Reset filters</button>
            </div>
          </div>

          {/* Grid */}
          <div className="lg:col-span-3">
            <div className="flex justify-between items-center mb-8">
              <span className="text-gray-500 font-medium">{items.length} items found</span>
              <div className="flex items-center space-x-2">
                <span className="text-sm text-gray-500">Sort:</span>
                <select className="bg-transparent border-none text-sm font-bold text-gray-900 outline-none cursor-pointer">
                  <option>Newest</option>
                  <option>Price: Low to High</option>
                  <option>Price: High to Low</option>
                </select>
              </div>
            </div>

            {loading ? (
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 animate-pulse">
                {[...Array(6)].map((_, i) => (
                  <div key={i} className="bg-gray-50 aspect-[3/4] rounded-2xl" />
                ))}
              </div>
            ) : (
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {items.map(item => (
                  <ItemCard key={item.id} item={item} />
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

const Sell = () => (
  <div className="max-w-3xl mx-auto px-4 py-20">
    <div className="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm">
      <h2 className="text-3xl font-bold mb-8 text-gray-900 text-center">Sell an item</h2>
      <form className="space-y-6">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="space-y-2">
            <label className="text-sm font-bold text-gray-700">Title</label>
            <input type="text" className="w-full px-4 py-3 rounded-xl border border-gray-200" placeholder="e.g. Dell Laptop" />
          </div>
          <div className="space-y-2">
            <label className="text-sm font-bold text-gray-700">Category</label>
            <select className="w-full px-4 py-3 rounded-xl border border-gray-200">
              <option>Electronics</option>
              <option>Stationery</option>
              <option>Clothes</option>
              <option>Shoes</option>
              <option>Food & Beverage</option>
            </select>
          </div>
        </div>
        <div className="space-y-2">
          <label className="text-sm font-bold text-gray-700">Price in ETB</label>
          <input type="number" className="w-full px-4 py-3 rounded-xl border border-gray-200" placeholder="0.00" />
        </div>
        <div className="space-y-2">
          <label className="text-sm font-bold text-gray-700">Description</label>
          <textarea className="w-full px-4 py-3 rounded-xl border border-gray-200" rows={4} placeholder="Describe your item..."></textarea>
        </div>
        <button type="button" className="w-full py-4 bg-blue-900 text-white font-bold rounded-2xl hover:bg-blue-800 transition-all">Submit for approval</button>
      </form>
    </div>
  </div>
);

const Login = () => (
  <div className="max-w-md mx-auto px-4 py-32">
    <div className="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm text-center">
      <h2 className="text-3xl font-bold mb-2 text-gray-900">Welcome back</h2>
      <p className="text-gray-500 mb-10">Sign in with your ASTU email.</p>
      <form className="space-y-4 text-left">
        <label className="block space-y-2">
          <span className="text-sm font-bold text-gray-700">Email</span>
          <input type="email" className="w-full px-4 py-3 rounded-xl border border-gray-200" placeholder="you@astu.edu.et" />
        </label>
        <label className="block space-y-2">
          <span className="text-sm font-bold text-gray-700">Password</span>
          <input type="password" className="w-full px-4 py-3 rounded-xl border border-gray-200" />
        </label>
        <button type="button" className="w-full py-4 bg-blue-900 text-white font-bold rounded-2xl hover:bg-blue-800 transition-all mt-4">Sign in</button>
      </form>
      <p className="mt-8 text-sm text-gray-400">
        New to UniTrade? <Link to="/signup" className="text-blue-900 font-bold">Create account</Link>
      </p>
    </div>
  </div>
);

const Contact = () => (
  <div className="max-w-5xl mx-auto px-4 py-20">
    <div className="grid md:grid-cols-2 gap-16">
      <div>
        <h1 className="text-4xl font-bold mb-6 text-gray-900">Get in touch</h1>
        <p className="text-lg text-gray-500 mb-10">Questions, feedback or trouble with a listing? We're here to help.</p>
        <div className="space-y-8">
          <div>
            <h3 className="font-bold text-gray-900 mb-2">Email</h3>
            <p className="text-blue-900">yeabsiragetachew613@gmail.com</p>
          </div>
          <div>
            <h3 className="font-bold text-gray-900 mb-2">Telegram Support</h3>
            <p className="text-blue-900">t.me/unitrade_support</p>
          </div>
          <div>
            <h3 className="font-bold text-gray-900 mb-2">ASTU Campus</h3>
            <p className="text-gray-500">Adama Science and Technology University<br/>P.O. Box 1888, Adama, Ethiopia</p>
          </div>
        </div>
      </div>
      <div className="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm">
        <form className="space-y-6">
          <div className="space-y-2">
            <label className="text-sm font-bold text-gray-700">Full Name</label>
            <input type="text" className="w-full px-4 py-3 rounded-xl border border-gray-200" />
          </div>
          <div className="space-y-2">
            <label className="text-sm font-bold text-gray-700">ASTU Email</label>
            <input type="email" className="w-full px-4 py-3 rounded-xl border border-gray-200" />
          </div>
          <div className="space-y-2">
            <label className="text-sm font-bold text-gray-700">Message</label>
            <textarea className="w-full px-4 py-3 rounded-xl border border-gray-200" rows={4}></textarea>
          </div>
          <button type="button" className="w-full py-4 bg-blue-900 text-white font-bold rounded-2xl hover:bg-blue-800 transition-all">Send message</button>
        </form>
      </div>
    </div>
  </div>
);

export default function App() {
  return (
    <Router>
      <div className="min-h-screen flex flex-col font-sans text-slate-900 antialiased">
        <Navbar />
        <main className="flex-grow">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/marketplace" element={<Marketplace />} />
            <Route path="/sell" element={<Sell />} />
            <Route path="/contact" element={<Contact />} />
            <Route path="/login" element={<Login />} />
            <Route path="/signup" element={<Login />} /> 
          </Routes>
        </main>
        <Footer />
      </div>
    </Router>
  );
}
