<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Http\JsonResponse;

class FrontendController extends Controller
{
    /**
     * Get all books
     */
    public function getBooks(): JsonResponse
    {
        try {
            $books = Book::with(['author', 'genreRelation', 'formatRelation'])->get();
            return response()->json([
                'data' => $books,
                'count' => $books->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Get featured books (sorted by rating)
     */
    public function getFeaturedBooks(): JsonResponse
    {
        $books = Book::with(['author', 'genreRelation', 'formatRelation'])
            ->orderByDesc('rating')
            ->limit(12)
            ->get();

        return response()->json(['data' => $books]);
    }

    /**
     * Get single book by ID
     */
    public function getBook($id): JsonResponse
    {
        $book = Book::with(['author', 'genreRelation', 'formatRelation'])
            ->findOrFail($id);

        $reviews = Review::where('book_id', $id)
            ->where('is_approved', true)
            ->with('user')
            ->get();

        $relatedBooks = Book::where('genre_id', $book->genre_id)
            ->where('id', '!=', $id)
            ->with(['author', 'genreRelation', 'formatRelation'])
            ->limit(8)
            ->get();

        return response()->json([
            'book' => $book,
            'reviews' => $reviews,
            'relatedBooks' => $relatedBooks,
        ]);
    }

    /**
     * Get all authors with their books count
     */
    public function getAuthors(): JsonResponse
    {
        $authors = Author::withCount('books')
            ->orderBy('name')
            ->get();

        return response()->json($authors);
    }

    /**
     * Get single author with their books
     */
    public function getAuthor($id): JsonResponse
    {
        $author = Author::with(['books' => function ($query) {
            $query->with(['genreRelation', 'formatRelation']);
        }])
            ->findOrFail($id);

        return response()->json($author);
    }

    /**
     * Get all genres
     */
    public function getGenres(): JsonResponse
    {
        $genres = Genre::where('is_active', true)
            ->withCount('books')
            ->get();

        return response()->json($genres);
    }

    /**
     * Search books by title, author, or genre
     */
    public function searchBooks($query): JsonResponse
    {
        $books = Book::with(['author', 'genreRelation', 'formatRelation'])
            ->where('title', 'like', "%{$query}%")
            ->orWhereHas('author', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('genreRelation', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->limit(20)
            ->get();

        return response()->json(['data' => $books]);
    }

    /**
     * Filter books by genre
     */
    public function filterByGenre($genreId): JsonResponse
    {
        $books = Book::where('genre_id', $genreId)
            ->with(['author', 'genreRelation', 'formatRelation'])
            ->get();

        return response()->json([
            'data' => $books,
            'count' => $books->count()
        ]);
    }

    /**
     * Get dashboard stats
     */
    public function getDashboardStats(): JsonResponse
    {
        return response()->json([
            'totalBooks' => Book::count(),
            'totalAuthors' => Author::count(),
            'totalGenres' => Genre::where('is_active', true)->count(),
            'averageRating' => Book::avg('rating'),
        ]);
    }
}
