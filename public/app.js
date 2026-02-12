const BOOKS = [
    {
        id: "b1",
        title: "Harbor of Quiet Minds",
        author: "Elena Richardson",
        authorId: "elena-richardson",
        genre: "Mindfulness",
        format: "Paperback",
        price: 18.99,
        year: 2024,
        rating: 4.8,
        blurb: "Practical rituals to reduce noise and reclaim focus in modern life.",
        coverTone: "#2874f0",
    },
    {
        id: "b2",
        title: "The Last Ink Merchant",
        author: "Jonas Hale",
        authorId: "jonas-hale",
        genre: "Historical Fiction",
        format: "Hardcover",
        price: 24.5,
        year: 2025,
        rating: 4.6,
        blurb: "A bookseller in 1890 Lisbon uncovers a ledger tied to vanished poets.",
        coverTone: "#ff9f00",
    },
    {
        id: "b3",
        title: "Code and Candlelight",
        author: "Mira Patel",
        authorId: "mira-patel",
        genre: "Technology",
        format: "eBook",
        price: 14.0,
        year: 2026,
        rating: 4.7,
        blurb: "Stories from teams that shipped calm systems in chaotic environments.",
        coverTone: "#2e7dff",
    },
    {
        id: "b4",
        title: "Blue Atlas of Small Towns",
        author: "Priya Deshmukh",
        authorId: "priya-deshmukh",
        genre: "Travel",
        format: "Paperback",
        price: 19.75,
        year: 2023,
        rating: 4.3,
        blurb: "A lyrical route through overlooked bookstores and station roads.",
        coverTone: "#4c8bf5",
    },
    {
        id: "b5",
        title: "Before the Rain Archive",
        author: "Jonas Hale",
        authorId: "jonas-hale",
        genre: "Mystery",
        format: "Paperback",
        price: 16.2,
        year: 2022,
        rating: 4.2,
        blurb: "A librarian decodes weather logs that predict missing-person cases.",
        coverTone: "#607d8b",
    },
    {
        id: "b6",
        title: "Designing Reading Rituals",
        author: "Elena Richardson",
        authorId: "elena-richardson",
        genre: "Self Growth",
        format: "Audiobook",
        price: 21.0,
        year: 2025,
        rating: 4.9,
        blurb: "How communities build meaningful daily reading habits that stick.",
        coverTone: "#26a69a",
    },
    {
        id: "b7",
        title: "Lanterns Over Vector Bay",
        author: "Mira Patel",
        authorId: "mira-patel",
        genre: "Science Fiction",
        format: "Hardcover",
        price: 26.9,
        year: 2026,
        rating: 4.5,
        blurb: "Engineers map dream currents in a floating city built on old myths.",
        coverTone: "#3f51b5",
    },
    {
        id: "b8",
        title: "The Saffron Ledger",
        author: "Priya Deshmukh",
        authorId: "priya-deshmukh",
        genre: "Business",
        format: "eBook",
        price: 12.8,
        year: 2024,
        rating: 4.1,
        blurb: "A founder-friendly guide to ethical growth and operational clarity.",
        coverTone: "#ff9800",
    },
    {
        id: "b9",
        title: "Winter Letters to August",
        author: "Clara Mendez",
        authorId: "clara-mendez",
        genre: "Romance",
        format: "Paperback",
        price: 17.4,
        year: 2023,
        rating: 4.4,
        blurb: "A long-distance romance unfolds through mailed book annotations.",
        coverTone: "#e91e63",
    },
    {
        id: "b10",
        title: "Earth Notes for New Gardeners",
        author: "Owen Clarke",
        authorId: "owen-clarke",
        genre: "Lifestyle",
        format: "Hardcover",
        price: 22.3,
        year: 2021,
        rating: 4.0,
        blurb: "A practical month-by-month guide to urban balcony gardening.",
        coverTone: "#4caf50",
    },
    {
        id: "b11",
        title: "Paper Lantern Economics",
        author: "Priya Deshmukh",
        authorId: "priya-deshmukh",
        genre: "Business",
        format: "Paperback",
        price: 20.6,
        year: 2026,
        rating: 4.6,
        blurb: "Simple financial frameworks for independent creators and small teams.",
        coverTone: "#ef6c00",
    },
    {
        id: "b12",
        title: "Threaded Rivers",
        author: "Clara Mendez",
        authorId: "clara-mendez",
        genre: "Romance",
        format: "Hardcover",
        price: 23.4,
        year: 2025,
        rating: 4.5,
        blurb: "Two readers reconnect through margin notes in second-hand novels.",
        coverTone: "#ab47bc",
    },
    {
        id: "b13",
        title: "The Practical Night Reader",
        author: "Elena Richardson",
        authorId: "elena-richardson",
        genre: "Self Growth",
        format: "eBook",
        price: 11.9,
        year: 2026,
        rating: 4.7,
        blurb: "Sleep-friendly routines that still make room for consistent reading.",
        coverTone: "#00897b",
    },
    {
        id: "b14",
        title: "Rust Maps and Radio Stars",
        author: "Jonas Hale",
        authorId: "jonas-hale",
        genre: "Historical Fiction",
        format: "Paperback",
        price: 18.4,
        year: 2024,
        rating: 4.4,
        blurb: "A vanished station journal redraws one family history after another.",
        coverTone: "#5d4037",
    },
    {
        id: "b15",
        title: "Systems at Dawn",
        author: "Mira Patel",
        authorId: "mira-patel",
        genre: "Technology",
        format: "Audiobook",
        price: 19.9,
        year: 2026,
        rating: 4.8,
        blurb: "A field guide to dependable product teams under changing priorities.",
        coverTone: "#3949ab",
    },
    {
        id: "b16",
        title: "Balcony Harvest Calendar",
        author: "Owen Clarke",
        authorId: "owen-clarke",
        genre: "Lifestyle",
        format: "Paperback",
        price: 15.6,
        year: 2025,
        rating: 4.3,
        blurb: "Monthly planting plans for readers growing herbs and vegetables at home.",
        coverTone: "#558b2f",
    },
];

const AUTHORS = [
    {
        id: "elena-richardson",
        name: "Elena Richardson",
        specialty: "Mindfulness",
        city: "Seattle, WA",
        followers: "42k",
        publishedBooks: 7,
        quote: "Books slow us down just enough to hear our own voice again.",
        bio: "Elena writes on intentional routines, reading circles, and sustainable creativity. Her workshops are used by libraries and wellness communities worldwide.",
    },
    {
        id: "jonas-hale",
        name: "Jonas Hale",
        specialty: "Historical Fiction",
        city: "Portland, OR",
        followers: "29k",
        publishedBooks: 5,
        quote: "History hides in side alleys, receipts, and forgotten marginalia.",
        bio: "Jonas reconstructs small forgotten histories and folds them into character-driven fiction. He often researches in independent archives and maritime records.",
    },
    {
        id: "mira-patel",
        name: "Mira Patel",
        specialty: "Technology",
        city: "Austin, TX",
        followers: "35k",
        publishedBooks: 4,
        quote: "Readable systems are written by teams, not heroes.",
        bio: "Mira blends software leadership with speculative storytelling. Her work focuses on humane product development and resilient engineering practices.",
    },
    {
        id: "priya-deshmukh",
        name: "Priya Deshmukh",
        specialty: "Travel",
        city: "Boston, MA",
        followers: "21k",
        publishedBooks: 6,
        quote: "A city reveals itself through its smallest bookstores.",
        bio: "Priya writes at the intersection of travel, entrepreneurship, and culture. Her essays profile local creators and independent publishing scenes.",
    },
    {
        id: "clara-mendez",
        name: "Clara Mendez",
        specialty: "Romance",
        city: "San Diego, CA",
        followers: "18k",
        publishedBooks: 3,
        quote: "Love stories are really stories about timing and courage.",
        bio: "Clara writes contemporary romance anchored in letters, memory, and coastal towns. She mentors first-time fiction writers through local workshops.",
    },
    {
        id: "owen-clarke",
        name: "Owen Clarke",
        specialty: "Lifestyle",
        city: "Denver, CO",
        followers: "15k",
        publishedBooks: 5,
        quote: "Good advice is concrete, seasonal, and kind to beginners.",
        bio: "Owen writes practical books about home gardening, food, and sustainable habits. His guides are aimed at readers starting with small spaces and tight schedules.",
    },
];

const currency = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
});

const byId = (id) => document.getElementById(id);
const DUMMY_WISHLIST_BOOK_IDS = ["b2", "b6", "b12"];
const DUMMY_CART_BOOK_IDS = ["b1", "b7", "b15"];

const wishlistIds = new Set();
const cartIds = new Set();
let drawerMode = "wishlist";

function getBookById(bookId) {
    return BOOKS.find((book) => book.id === bookId);
}

function syncBookActionButtons(root = document) {
    root.querySelectorAll(".js-wishlist[data-book-id]").forEach((button) => {
        const bookId = button.dataset.bookId;
        const saved = wishlistIds.has(bookId);
        button.dataset.active = saved ? "true" : "false";
        button.textContent = saved ? "Saved" : "Save";
        button.classList.toggle("active", saved);
    });

    root.querySelectorAll(".js-add-cart[data-book-id]").forEach((button) => {
        const bookId = button.dataset.bookId;
        const inCart = cartIds.has(bookId);
        button.dataset.added = inCart ? "true" : "false";
        button.textContent = inCart ? "Added to Cart" : "Add to Cart";
        button.classList.toggle("added", inCart);
    });
}

function updateTopUtilityCounts() {
    const wishlistBadge = byId("wishlistCountBadge");
    const cartBadge = byId("cartCountBadge");
    if (wishlistBadge) {
        wishlistBadge.textContent = String(DUMMY_WISHLIST_BOOK_IDS.length);
        wishlistBadge.classList.remove("hidden");
    }
    if (cartBadge) {
        cartBadge.textContent = String(DUMMY_CART_BOOK_IDS.length);
        cartBadge.classList.remove("hidden");
    }
}

function renderSideDrawer() {
    const drawerTitle = byId("drawerTitle");
    const drawerList = byId("drawerList");
    if (!drawerTitle || !drawerList) return;

    drawerTitle.textContent = drawerMode === "wishlist" ? "Wishlist" : "Cart";
    document.querySelectorAll(".drawer-tab").forEach((tab) => {
        tab.classList.toggle("active", tab.dataset.mode === drawerMode);
    });

    const ids =
        drawerMode === "wishlist"
            ? DUMMY_WISHLIST_BOOK_IDS
            : DUMMY_CART_BOOK_IDS;
    if (!ids.length) {
        drawerList.innerHTML = `<p class="muted" style="margin:0;">Your ${drawerMode} is empty.</p>`;
        return;
    }

    drawerList.innerHTML = ids
        .map((bookId) => {
            const book = getBookById(bookId);
            if (!book) return "";
            return `
        <article class="drawer-item">
          <div class="drawer-item-head">
            <strong>${book.title}</strong>
            <span class="muted">${currency.format(book.price)}</span>
          </div>
          <p class="muted" style="margin:0;">by ${book.author}</p>
          <div class="drawer-item-actions">
            <a class="button secondary" href="book-detail?id=${book.id}">View</a>
          </div>
        </article>
      `;
        })
        .join("");
}

function openSideDrawer(mode) {
    if (mode) drawerMode = mode;
    const overlay = byId("sideDrawerOverlay");
    const drawer = byId("sideDrawer");
    if (!overlay || !drawer) return;
    overlay.classList.add("open");
    drawer.classList.add("open");
    document.body.classList.add("drawer-open");
    renderSideDrawer();
}

function closeSideDrawer() {
    const overlay = byId("sideDrawerOverlay");
    const drawer = byId("sideDrawer");
    if (!overlay || !drawer) return;
    overlay.classList.remove("open");
    drawer.classList.remove("open");
    document.body.classList.remove("drawer-open");
}

function setWishlist(bookId, shouldSave) {
    if (!bookId) return;
    if (shouldSave) wishlistIds.add(bookId);
    else wishlistIds.delete(bookId);
    syncBookActionButtons();
}

function addToCart(bookId) {
    if (!bookId) return;
    cartIds.add(bookId);
    syncBookActionButtons();
}

function mountTopUtilities() {
    const headerInner = document.querySelector(".header-inner");
    if (!headerInner || headerInner.querySelector(".top-utilities")) return;

    const isAuthed = document.body.dataset.auth === "1";
    const primaryLink = isAuthed
        ? '<a class="login-btn" href="user/dashboard" aria-label="Dashboard">Dashboard</a>'
        : '<a class="login-btn" href="login" aria-label="Login">Login</a>';

    headerInner.insertAdjacentHTML(
        "beforeend",
        `
      <div class="top-utilities">
                ${primaryLink}
        <button type="button" class="utility-btn js-open-wishlist" aria-label="Open wishlist" title="Wishlist">
          <span class="utility-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <path d="M12 20.5 4.6 13.8a5 5 0 0 1 7.1-7.1L12 7l.3-.3a5 5 0 0 1 7.1 7.1z" />
            </svg>
          </span>
          <span id="wishlistCountBadge" class="utility-badge hidden">0</span>
        </button>
        <button type="button" class="utility-btn js-open-cart" aria-label="Open cart" title="Cart">
          <span class="utility-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" role="presentation" focusable="false">
              <circle cx="9" cy="19.5" r="1.4" />
              <circle cx="17.5" cy="19.5" r="1.4" />
              <path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 7H7.1" />
            </svg>
          </span>
          <span id="cartCountBadge" class="utility-badge hidden">0</span>
        </button>
      </div>
    `,
    );
}

function mountSideDrawer() {
    if (byId("sideDrawer")) return;

    document.body.insertAdjacentHTML(
        "beforeend",
        `
      <div id="sideDrawerOverlay" class="side-drawer-overlay"></div>
      <aside id="sideDrawer" class="side-drawer" aria-label="Wishlist and cart panel">
        <div class="side-drawer-head">
          <h3 id="drawerTitle">Wishlist</h3>
          <button type="button" class="drawer-close js-drawer-close" aria-label="Close panel">✕</button>
        </div>
        <div class="drawer-tabs">
          <button type="button" class="drawer-tab active js-drawer-tab" data-mode="wishlist">Wishlist</button>
          <button type="button" class="drawer-tab js-drawer-tab" data-mode="cart">Cart</button>
        </div>
        <div id="drawerList" class="drawer-list"></div>
      </aside>
    `,
    );
}

function mountHeaderUtilitiesAndDrawer() {
    mountTopUtilities();
    mountSideDrawer();
    updateTopUtilityCounts();
    renderSideDrawer();
}

function mountActiveNav() {
    const page = document.body.dataset.page;
    const normalizedPage =
        { "author-detail": "authors", "book-detail": "store" }[page] || page;
    document.querySelectorAll("[data-page-link]").forEach((link) => {
        if (link.dataset.pageLink === normalizedPage) {
            link.classList.add("active");
        }
    });
}

function initials(name) {
    return name
        .split(" ")
        .map((part) => part.charAt(0))
        .slice(0, 2)
        .join("");
}

function booksByAuthor(authorId) {
    return BOOKS.filter((book) => book.authorId === authorId);
}

function bookCardMarkup(book) {
    return `
    <article class="card reveal" data-book-id="${book.id}" data-title="${book.title.toLowerCase()}" data-author="${book.author.toLowerCase()}" data-genre="${book.genre}" data-format="${book.format}" data-price="${book.price}" data-rating="${book.rating}" data-year="${book.year}">
      <div class="book-cover" style="background: ${book.coverTone}">
        ${book.genre}
      </div>
      <h3>${book.title}</h3>
      <div class="meta-row">
        <span>by <a href="author-detail?id=${book.authorId}">${book.author}</a></span>
        <span>${book.year}</span>
      </div>
      <p class="muted">${book.blurb}</p>
      <div class="pill-row">
        <span class="pill">${book.format}</span>
        <span class="pill ghost">${book.genre}</span>
      </div>
      <div class="price-row">
        <strong>${currency.format(book.price)}</strong>
        <span>Rating ${book.rating}</span>
      </div>
      <div class="product-actions">
        <button type="button" class="button secondary js-wishlist" data-book-id="${book.id}">Save</button>
        <button type="button" class="button js-add-cart" data-book-id="${book.id}">Add to Cart</button>
      </div>
    </article>
  `;
}

function authorCardMarkup(author) {
    return `
    <article class="card reveal" data-name="${author.name.toLowerCase()}" data-specialty="${author.specialty}" data-books="${author.publishedBooks}">
      <div style="display:flex;align-items:center;gap:.75rem;">
        <div class="author-avatar">${initials(author.name)}</div>
        <div>
          <h3>${author.name}</h3>
          <p class="muted" style="margin:.15rem 0 0;">${author.city}</p>
        </div>
      </div>
      <p class="muted" style="margin:0;">${author.bio}</p>
      <div class="pill-row">
        <span class="pill">${author.specialty}</span>
        <span class="pill ghost">${author.publishedBooks} books</span>
      </div>
      <div class="meta-row">
        <span>${author.followers} followers</span>
        <div class="author-actions">
          <button type="button" class="button secondary js-follow" data-author-id="${author.id}">Follow</button>
          <a class="button secondary" href="author-detail?id=${author.id}">View Profile</a>
        </div>
      </div>
    </article>
  `;
}

function populateSelect(select, values, defaultLabel) {
    if (!select) return;
    select.innerHTML = `<option value="all">${defaultLabel}</option>`;
    values.forEach((value) => {
        const option = document.createElement("option");
        option.value = value;
        option.textContent = value;
        select.append(option);
    });
}

function renderHomePage() {
    const featuredBookGrid = byId("featuredBookGrid");
    const featuredAuthorGrid = byId("featuredAuthorGrid");
    if (!featuredBookGrid || !featuredAuthorGrid) return;

    const topBooks = [...BOOKS].sort((a, b) => b.rating - a.rating).slice(0, 8);
    const topAuthors = [...AUTHORS]
        .sort((a, b) => b.publishedBooks - a.publishedBooks)
        .slice(0, 3);
    const moreBooks = [...BOOKS]
        .sort((a, b) => b.year - a.year || b.rating - a.rating)
        .slice(0, 10);
    const highlightBooks = [...BOOKS]
        .sort((a, b) => b.rating - a.rating || b.year - a.year)
        .slice(0, 6);

    featuredBookGrid.innerHTML = topBooks.map(bookCardMarkup).join("");
    featuredAuthorGrid.innerHTML = topAuthors.map(authorCardMarkup).join("");
    syncBookActionButtons(featuredBookGrid);
    const moreBookGrid = byId("moreBookGrid");
    if (moreBookGrid) {
        moreBookGrid.innerHTML = moreBooks.map(bookCardMarkup).join("");
        syncBookActionButtons(moreBookGrid);
    }

    byId("homeBookCount").textContent = String(BOOKS.length);
    byId("homeAuthorCount").textContent = String(AUTHORS.length);
    byId("homeGenreCount").textContent = String(
        new Set(BOOKS.map((b) => b.genre)).size,
    );

    const highlightMain = byId("highlightMain");
    const highlightThumbs = byId("highlightThumbs");
    const highlightPrev = byId("highlightPrev");
    const highlightNext = byId("highlightNext");

    if (
        highlightMain &&
        highlightThumbs &&
        highlightPrev &&
        highlightNext &&
        highlightBooks.length > 0
    ) {
        let activeIndex = 0;

        const renderActiveBook = () => {
            const book = highlightBooks[activeIndex];
            highlightMain.style.borderTop = `4px solid ${book.coverTone}`;
            highlightMain.innerHTML = `
        <div class="highlight-main-head">
          <span class="highlight-chip">${book.genre}</span>
          <span class="highlight-year">${book.year}</span>
        </div>
        <h3>${book.title}</h3>
        <p class="muted">by <a href="author-detail?id=${book.authorId}">${book.author}</a></p>
        <p class="muted">${book.blurb}</p>
        <div class="highlight-meta">
          <strong>${currency.format(book.price)}</strong>
          <span>Rating ${book.rating.toFixed(1)}</span>
        </div>
        <div class="meta-row">
          <a class="button secondary" href="book-detail?id=${book.id}">View Details</a>
          <a class="button secondary" href="author-detail?id=${book.authorId}">About Author</a>
        </div>
        <div class="product-actions">
          <button type="button" class="button secondary js-wishlist" data-book-id="${book.id}">Save</button>
          <button type="button" class="button js-add-cart" data-book-id="${book.id}">Add to Cart</button>
        </div>
      `;
            syncBookActionButtons(highlightMain);
        };

        highlightThumbs.innerHTML = highlightBooks
            .map(
                (book, idx) => `
          <button type="button" class="highlight-thumb" data-index="${idx}" style="border-top: 3px solid ${book.coverTone};">
            <span class="highlight-thumb-title">${book.title}</span>
            <span class="highlight-thumb-meta">${currency.format(book.price)} · ${book.rating.toFixed(1)}</span>
          </button>
        `,
            )
            .join("");

        const thumbButtons = [
            ...highlightThumbs.querySelectorAll(".highlight-thumb"),
        ];

        const applyActive = (idx) => {
            activeIndex = (idx + highlightBooks.length) % highlightBooks.length;
            renderActiveBook();
            thumbButtons.forEach((button, buttonIndex) => {
                button.classList.toggle("active", buttonIndex === activeIndex);
            });
        };

        highlightPrev.addEventListener("click", () =>
            applyActive(activeIndex - 1),
        );
        highlightNext.addEventListener("click", () =>
            applyActive(activeIndex + 1),
        );
        thumbButtons.forEach((button, idx) => {
            button.addEventListener("click", () => applyActive(idx));
        });

        applyActive(0);
        if (highlightBooks.length > 1) {
            window.setInterval(() => applyActive(activeIndex + 1), 5200);
        }
    }
}

function renderStorePage() {
    const bookGrid = byId("bookGrid");
    if (!bookGrid) return;

    const searchInput = byId("bookSearch");
    const genreFilter = byId("genreFilter");
    const formatFilter = byId("formatFilter");
    const sortFilter = byId("sortFilter");
    const ratingFilter = byId("ratingFilter");
    const yearFilter = byId("yearFilter");
    const maxPriceRange = byId("maxPriceRange");
    const maxPriceValue = byId("maxPriceValue");
    const dealOnly = byId("dealOnly");
    const emptyState = byId("bookEmptyState");
    const countNode = byId("bookCount");
    const activeFiltersNode = byId("activeFilters");
    const clearFiltersBtn = byId("clearFiltersBtn");

    populateSelect(
        genreFilter,
        [...new Set(BOOKS.map((book) => book.genre))].sort(),
        "All genres",
    );
    populateSelect(
        formatFilter,
        [...new Set(BOOKS.map((book) => book.format))].sort(),
        "All formats",
    );

    const maxCatalogPrice = Math.ceil(
        Math.max(...BOOKS.map((book) => book.price)),
    );
    const minCatalogPrice = Math.floor(
        Math.min(...BOOKS.map((book) => book.price)),
    );

    if (maxPriceRange) {
        maxPriceRange.min = String(minCatalogPrice);
        maxPriceRange.max = String(maxCatalogPrice);
        maxPriceRange.value = String(maxCatalogPrice);
    }

    if (yearFilter) {
        yearFilter.innerHTML = '<option value="all">All years</option>';
        [...new Set(BOOKS.map((book) => book.year))]
            .sort((a, b) => b - a)
            .forEach((year) => {
                const option = document.createElement("option");
                option.value = String(year);
                option.textContent = String(year);
                yearFilter.append(option);
            });
    }

    const updatePriceLabel = () => {
        if (maxPriceValue && maxPriceRange) {
            maxPriceValue.textContent = currency.format(
                Number(maxPriceRange.value),
            );
        }
    };

    const applyFilters = () => {
        const query = searchInput.value.trim().toLowerCase();
        const selectedGenre = genreFilter.value;
        const selectedFormat = formatFilter.value;
        const sortBy = sortFilter.value;
        const minRating = ratingFilter ? Number(ratingFilter.value) : 0;
        const selectedYear = yearFilter ? yearFilter.value : "all";
        const maxPrice = maxPriceRange
            ? Number(maxPriceRange.value)
            : maxCatalogPrice;
        const dealsOnly = dealOnly ? dealOnly.checked : false;

        let filtered = BOOKS.filter((book) => {
            const matchesQuery =
                book.title.toLowerCase().includes(query) ||
                book.author.toLowerCase().includes(query) ||
                book.genre.toLowerCase().includes(query);
            const matchesGenre =
                selectedGenre === "all" || book.genre === selectedGenre;
            const matchesFormat =
                selectedFormat === "all" || book.format === selectedFormat;
            const matchesRating = book.rating >= minRating;
            const matchesYear =
                selectedYear === "all" || book.year === Number(selectedYear);
            const matchesMaxPrice = book.price <= maxPrice;
            const matchesDealsOnly = !dealsOnly || book.price < 20;
            return (
                matchesQuery &&
                matchesGenre &&
                matchesFormat &&
                matchesRating &&
                matchesYear &&
                matchesMaxPrice &&
                matchesDealsOnly
            );
        });

        switch (sortBy) {
            case "newest":
                filtered = filtered.sort((a, b) => b.year - a.year);
                break;
            case "price-low":
                filtered = filtered.sort((a, b) => a.price - b.price);
                break;
            case "price-high":
                filtered = filtered.sort((a, b) => b.price - a.price);
                break;
            case "rating":
                filtered = filtered.sort((a, b) => b.rating - a.rating);
                break;
            default:
                filtered = filtered.sort((a, b) =>
                    a.title.localeCompare(b.title),
                );
                break;
        }

        countNode.textContent = `${filtered.length} books`;
        bookGrid.innerHTML = filtered.map(bookCardMarkup).join("");
        syncBookActionButtons(bookGrid);
        emptyState.style.display = filtered.length === 0 ? "block" : "none";

        if (activeFiltersNode) {
            const sortLabels = {
                title: "Title A-Z",
                newest: "Newest first",
                rating: "Top rating",
                "price-low": "Price low to high",
                "price-high": "Price high to low",
            };

            const chips = [];
            if (query) chips.push(`Search: ${searchInput.value.trim()}`);
            if (selectedGenre !== "all") chips.push(`Genre: ${selectedGenre}`);
            if (selectedFormat !== "all")
                chips.push(`Format: ${selectedFormat}`);
            if (minRating > 0)
                chips.push(`Min rating: ${minRating.toFixed(1)}+`);
            if (selectedYear !== "all") chips.push(`Year: ${selectedYear}`);
            if (maxPrice < maxCatalogPrice)
                chips.push(`Max price: ${currency.format(maxPrice)}`);
            if (dealsOnly) chips.push("Deals only");
            if (sortBy !== "title") chips.push(`Sort: ${sortLabels[sortBy]}`);

            activeFiltersNode.innerHTML = chips.length
                ? chips
                      .map(
                          (label) => `<span class="pill ghost">${label}</span>`,
                      )
                      .join("")
                : '<span class="muted">No active filters</span>';
        }
    };

    [
        searchInput,
        genreFilter,
        formatFilter,
        sortFilter,
        ratingFilter,
        yearFilter,
        maxPriceRange,
        dealOnly,
    ].forEach((control) => {
        if (!control) return;
        control.addEventListener("input", () => {
            updatePriceLabel();
            applyFilters();
        });
        control.addEventListener("change", () => {
            updatePriceLabel();
            applyFilters();
        });
    });

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", () => {
            searchInput.value = "";
            genreFilter.value = "all";
            formatFilter.value = "all";
            sortFilter.value = "title";
            if (ratingFilter) ratingFilter.value = "0";
            if (yearFilter) yearFilter.value = "all";
            if (maxPriceRange) maxPriceRange.value = String(maxCatalogPrice);
            if (dealOnly) dealOnly.checked = false;
            updatePriceLabel();
            applyFilters();
        });
    }

    updatePriceLabel();
    applyFilters();
}

function renderAuthorsPage() {
    const authorGrid = byId("authorGrid");
    if (!authorGrid) return;

    const searchInput = byId("authorSearch");
    const specialtyFilter = byId("specialtyFilter");
    const cityFilter = byId("cityFilter");
    const minBooksFilter = byId("minBooksFilter");
    const followersFilter = byId("followersFilter");
    const authorSortFilter = byId("authorSortFilter");
    const emptyState = byId("authorEmptyState");
    const countNode = byId("authorCount");
    const activeFiltersNode = byId("activeAuthorFilters");
    const clearFiltersBtn = byId("clearAuthorFiltersBtn");
    const spotlightNode = byId("authorSpotlight");

    populateSelect(
        specialtyFilter,
        [...new Set(AUTHORS.map((author) => author.specialty))].sort(),
        "All specialties",
    );
    if (cityFilter) {
        populateSelect(
            cityFilter,
            [...new Set(AUTHORS.map((author) => author.city))].sort(),
            "All cities",
        );
    }

    const parseFollowers = (value) =>
        Number(String(value).replace(/[^0-9.]/g, "")) || 0;

    const applyFilters = () => {
        const query = searchInput.value.trim().toLowerCase();
        const specialty = specialtyFilter.value;
        const city = cityFilter ? cityFilter.value : "all";
        const minBooks = Number(minBooksFilter.value);
        const minFollowers = followersFilter
            ? Number(followersFilter.value)
            : 0;
        const sortBy = authorSortFilter ? authorSortFilter.value : "name";

        let filtered = AUTHORS.filter((author) => {
            const matchesQuery =
                author.name.toLowerCase().includes(query) ||
                author.specialty.toLowerCase().includes(query) ||
                author.city.toLowerCase().includes(query);
            const matchesSpecialty =
                specialty === "all" || author.specialty === specialty;
            const matchesCity = city === "all" || author.city === city;
            const matchesBookCount = author.publishedBooks >= minBooks;
            const matchesFollowers =
                parseFollowers(author.followers) >= minFollowers;
            return (
                matchesQuery &&
                matchesSpecialty &&
                matchesCity &&
                matchesBookCount &&
                matchesFollowers
            );
        });

        switch (sortBy) {
            case "followers":
                filtered = filtered.sort(
                    (a, b) =>
                        parseFollowers(b.followers) -
                        parseFollowers(a.followers),
                );
                break;
            case "books":
                filtered = filtered.sort(
                    (a, b) =>
                        b.publishedBooks - a.publishedBooks ||
                        a.name.localeCompare(b.name),
                );
                break;
            default:
                filtered = filtered.sort((a, b) =>
                    a.name.localeCompare(b.name),
                );
                break;
        }

        countNode.textContent = `${filtered.length} authors`;
        authorGrid.innerHTML = filtered.map(authorCardMarkup).join("");
        emptyState.style.display = filtered.length === 0 ? "block" : "none";

        if (activeFiltersNode) {
            const sortLabels = {
                name: "Name A-Z",
                followers: "Most followers",
                books: "Most books",
            };

            const chips = [];
            if (query) chips.push(`Search: ${searchInput.value.trim()}`);
            if (specialty !== "all") chips.push(`Specialty: ${specialty}`);
            if (city !== "all") chips.push(`City: ${city}`);
            if (minBooks > 0) chips.push(`Min books: ${minBooks}+`);
            if (minFollowers > 0)
                chips.push(`Min followers: ${minFollowers}k+`);
            if (sortBy !== "name") chips.push(`Sort: ${sortLabels[sortBy]}`);

            activeFiltersNode.innerHTML = chips.length
                ? chips
                      .map(
                          (label) => `<span class="pill ghost">${label}</span>`,
                      )
                      .join("")
                : '<span class="muted">No active filters</span>';
        }

        if (spotlightNode) {
            if (!filtered.length) {
                spotlightNode.innerHTML =
                    '<p class="muted" style="margin:0;">No spotlight available for current filters.</p>';
            } else {
                const spotlight = filtered[0];
                spotlightNode.innerHTML = `
          <div style="display:flex;align-items:center;gap:.75rem;">
            <div class="author-avatar">${initials(spotlight.name)}</div>
            <div>
              <h3 style="margin:0;">Spotlight: ${spotlight.name}</h3>
              <p class="muted" style="margin:.2rem 0 0;">${spotlight.city} • ${spotlight.specialty}</p>
            </div>
          </div>
          <p class="muted" style="margin:0;">${spotlight.bio}</p>
          <div class="pill-row">
            <span class="pill">${spotlight.followers} followers</span>
            <span class="pill ghost">${spotlight.publishedBooks} books</span>
          </div>
          <a class="button secondary" href="author-detail?id=${spotlight.id}">View Spotlight Profile</a>
        `;
            }
        }
    };

    [
        searchInput,
        specialtyFilter,
        cityFilter,
        minBooksFilter,
        followersFilter,
        authorSortFilter,
    ].forEach((control) => {
        if (!control) return;
        control.addEventListener("input", applyFilters);
        control.addEventListener("change", applyFilters);
    });

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener("click", () => {
            searchInput.value = "";
            specialtyFilter.value = "all";
            if (cityFilter) cityFilter.value = "all";
            minBooksFilter.value = "0";
            if (followersFilter) followersFilter.value = "0";
            if (authorSortFilter) authorSortFilter.value = "name";
            applyFilters();
        });
    }

    applyFilters();
}

function renderAuthorDetailPage() {
    if (!byId("detailAuthorName")) return;

    const params = new URLSearchParams(window.location.search);
    const authorId = params.get("id");
    const author = AUTHORS.find((entry) => entry.id === authorId) || AUTHORS[0];
    const authorBooks = booksByAuthor(author.id);

    byId("detailAuthorName").textContent = author.name;
    byId("detailSpecialty").textContent = author.specialty;
    byId("detailCity").textContent = author.city;
    byId("detailFollowers").textContent = author.followers;
    byId("detailPublished").textContent = String(author.publishedBooks);
    byId("detailBio").textContent = author.bio;
    byId("detailQuote").textContent = `"${author.quote}"`;
    byId("detailAuthorNameDuplicate").textContent = author.name;
    byId("detailSpecialtyDuplicate").textContent = author.specialty;
    byId("detailInitial").textContent = initials(author.name);
    byId("detailCurrentAuthor").textContent = author.name;
    const booksLabel = byId("detailAuthorBooksLabel");
    if (booksLabel) booksLabel.textContent = author.name;
    const detailFollowBtn = byId("detailFollowBtn");
    if (detailFollowBtn) {
        detailFollowBtn.dataset.authorId = author.id;
        detailFollowBtn.dataset.active = "false";
        detailFollowBtn.textContent = "Follow";
        detailFollowBtn.classList.remove("following");
    }
    byId("detailBookGrid").innerHTML = authorBooks.map(bookCardMarkup).join("");
    syncBookActionButtons(byId("detailBookGrid"));
}

function renderBookDetailPage() {
    if (!byId("bookDetailTitle")) return;

    const params = new URLSearchParams(window.location.search);
    const bookId = params.get("id");
    const book = BOOKS.find((entry) => entry.id === bookId) || BOOKS[0];
    const relatedBooks = BOOKS.filter(
        (entry) => entry.id !== book.id && entry.genre === book.genre,
    )
        .sort((a, b) => b.rating - a.rating)
        .slice(0, 4);

    byId("bookCrumbTitle").textContent = book.title;
    byId("bookDetailTitle").textContent = book.title;
    byId("bookDetailBlurb").textContent = book.blurb;
    byId("bookDetailGenre").textContent = book.genre;
    byId("bookDetailFormat").textContent = book.format;
    byId("bookDetailGenreText").textContent = book.genre;
    byId("bookDetailFormatText").textContent = book.format;
    byId("bookDetailYear").textContent = String(book.year);
    byId("bookDetailPrice").textContent = currency.format(book.price);
    byId("bookDetailRating").textContent = `Rating ${book.rating.toFixed(1)}`;
    byId("bookDetailCover").style.background = book.coverTone;
    byId("bookDetailCover").textContent = book.genre;

    const authorLink = byId("bookDetailAuthorLink");
    const authorProfileLink = byId("bookDetailAuthorProfile");
    if (authorLink) {
        authorLink.textContent = book.author;
        authorLink.href = `author-detail?id=${book.authorId}`;
    }
    if (authorProfileLink) {
        authorProfileLink.href = `author-detail?id=${book.authorId}`;
    }

    const detailSaveBtn = byId("bookDetailSaveBtn");
    const detailCartBtn = byId("bookDetailCartBtn");
    if (detailSaveBtn) detailSaveBtn.dataset.bookId = book.id;
    if (detailCartBtn) detailCartBtn.dataset.bookId = book.id;

    const relatedGrid = byId("relatedBookGrid");
    if (relatedGrid) {
        const fallbackBooks = BOOKS.filter(
            (entry) => entry.id !== book.id,
        ).slice(0, 4);
        relatedGrid.innerHTML = (
            relatedBooks.length ? relatedBooks : fallbackBooks
        )
            .map(bookCardMarkup)
            .join("");
        syncBookActionButtons(relatedGrid);
    }
    syncBookActionButtons(document);
}

function mountProductActionHandlers() {
    document.addEventListener("click", (event) => {
        const openWishlistButton = event.target.closest(".js-open-wishlist");
        if (openWishlistButton) {
            openSideDrawer("wishlist");
            return;
        }

        const openCartButton = event.target.closest(".js-open-cart");
        if (openCartButton) {
            openSideDrawer("cart");
            return;
        }

        const drawerOverlay = event.target.closest("#sideDrawerOverlay");
        if (drawerOverlay) {
            closeSideDrawer();
            return;
        }

        const drawerCloseButton = event.target.closest(".js-drawer-close");
        if (drawerCloseButton) {
            closeSideDrawer();
            return;
        }

        const drawerTab = event.target.closest(".js-drawer-tab");
        if (drawerTab) {
            drawerMode = drawerTab.dataset.mode || "wishlist";
            renderSideDrawer();
            return;
        }

        const followButton = event.target.closest(".js-follow");
        if (followButton) {
            const isActive = followButton.dataset.active === "true";
            followButton.dataset.active = isActive ? "false" : "true";
            followButton.textContent = isActive ? "Follow" : "Following";
            followButton.classList.toggle("following", !isActive);
            return;
        }

        const wishlistButton = event.target.closest(".js-wishlist");
        if (wishlistButton) {
            const bookId = wishlistButton.dataset.bookId;
            const isActive = wishlistButton.dataset.active === "true";
            setWishlist(bookId, !isActive);
            return;
        }

        const cartButton = event.target.closest(".js-add-cart");
        if (cartButton) {
            addToCart(cartButton.dataset.bookId);
            return;
        }

        const productCard = event.target.closest(".card[data-book-id]");
        if (productCard) {
            if (event.target.closest("a, button, input, select, label")) return;
            const bookId = productCard.dataset.bookId;
            if (bookId) {
                window.location.href = `book-detail?id=${bookId}`;
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    mountActiveNav();
    mountHeaderUtilitiesAndDrawer();
    mountProductActionHandlers();

    const page = document.body.dataset.page;
    if (page === "home") renderHomePage();
    if (page === "store") renderStorePage();
    if (page === "authors") renderAuthorsPage();
    if (page === "author-detail") renderAuthorDetailPage();
    if (page === "book-detail") renderBookDetailPage();

    syncBookActionButtons(document);
    updateTopUtilityCounts();
});
