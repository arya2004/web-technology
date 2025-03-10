// controllers/bookController.js
const Book = require('../models/Book');

// 1) Seed books if empty
exports.initBooksIfEmpty = async () => {
  try {
    const count = await Book.countDocuments();
    if (count === 0) {
      console.log('No books found. Seeding initial data...');
      const sampleBooks = [
        {
          title: 'The Great Gatsby',
          author: 'F. Scott Fitzgerald',
          description: 'A classic novel set in the 1920s...',
          price: 10.99,
          image: '/images/sample1.jpg',
        },
        {
          title: '1984',
          author: 'George Orwell',
          description: 'Dystopian novel about totalitarian regime...',
          price: 12.99,
          image: '/images/sample2.jpg',
        },
        {
          title: 'Pride and Prejudice',
          author: 'Jane Austen',
          description: 'A classic novel of manners...',
          price: 9.99,
        },
        {
          title: 'To Kill a Mockingbird',
          author: 'Harper Lee',
          description: 'Story of racial injustice and childhood innocence...',
          price: 11.99,
        },
        {
          title: 'Moby-Dick',
          author: 'Herman Melville',
          description: 'Ishmael’s voyages on the whaling ship Pequod...',
          price: 8.99,
        },
        {
          title: 'The Catcher in the Rye',
          author: 'J.D. Salinger',
          description: 'The experiences of Holden Caulfield...',
          price: 7.49,
        },
        {
          title: 'Brave New World',
          author: 'Aldous Huxley',
          description: 'A futuristic society controlled by technology...',
          price: 14.99,
        },
        {
          title: 'The Hobbit',
          author: 'J.R.R. Tolkien',
          description: 'Bilbo Baggins’ unexpected journey...',
          price: 13.5,
        },
        {
          title: 'Fahrenheit 451',
          author: 'Ray Bradbury',
          description: 'Society where books are burned...',
          price: 10.5,
        },
        {
          title: 'Animal Farm',
          author: 'George Orwell',
          description: 'Political satire with farm animals...',
          price: 8.5,
        },
        // ...Add more if desired
      ];
      await Book.insertMany(sampleBooks);
      console.log('Sample books seeded successfully.');
    }
  } catch (error) {
    console.error('Error seeding books:', error);
  }
};

// 2) Show Catalogue (publicly accessible)
exports.showCatalogue = async (req, res) => {
  try {
    const books = await Book.find();
    // user might be undefined if not logged in
    const user = req.session.user;
    res.render('catalogue', { title: 'Catalogue', books, user });
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while retrieving books');
  }
};

// 3) GET Add Book (only if logged in)
exports.getAddBook = (req, res) => {
  if (!req.session.user) {
    return res.redirect('/users/login');
  }
  res.render('addBook', { title: 'Add New Book', user: req.session.user });
};

// 4) POST Add Book
exports.postAddBook = async (req, res) => {
  if (!req.session.user) {
    return res.redirect('/users/login');
  }
  try {
    const { title, author, description, price, image } = req.body;
    const newBook = new Book({ title, author, description, price, image });
    await newBook.save();
    res.redirect('/books/catalogue');
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while adding a book');
  }
};

// 5) GET Edit Book
exports.getEditBook = async (req, res) => {
  if (!req.session.user) {
    return res.redirect('/users/login');
  }
  try {
    const book = await Book.findById(req.params.id);
    if (!book) {
      return res.status(404).send('Book not found');
    }
    res.render('editBook', {
      title: 'Edit Book',
      book,
      user: req.session.user,
    });
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while fetching book');
  }
};

// 6) POST Edit Book
exports.postEditBook = async (req, res) => {
  if (!req.session.user) {
    return res.redirect('/users/login');
  }
  try {
    const { title, author, description, price, image } = req.body;
    await Book.findByIdAndUpdate(req.params.id, {
      title,
      author,
      description,
      price,
      image,
    });
    res.redirect('/books/catalogue');
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while updating book');
  }
};

// 7) DELETE Book
exports.deleteBook = async (req, res) => {
  if (!req.session.user) {
    return res.redirect('/users/login');
  }
  try {
    await Book.findByIdAndRemove(req.params.id);
    res.redirect('/books/catalogue');
  } catch (error) {
    console.error(error);
    res.status(500).send('Server error while deleting book');
  }
};
