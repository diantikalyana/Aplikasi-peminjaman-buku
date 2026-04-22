<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // SEARCH
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }

        $books = $query->latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required|integer',
            'cover' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // upload cover
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        $book = Book::create($data);

        // 🔔 Notifikasi ke semua user tentang buku baru
        NotificationService::notifyNewBook(
            $book->title,
            $book->author,
            route('dashboard')
        );

        // 🔔 Notifikasi admin tentang buku baru yang ditambahkan
        NotificationService::notifyAdminNewBook($book->title);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'stock' => 'required|integer',
            'cover' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // kalau upload cover baru
        if ($request->hasFile('cover')) {

            // hapus cover lama
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // simpan cover baru
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        // hapus cover juga
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        $query = Book::with('category');

        // SEARCH
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }

        $books = $query->latest()->get();
        $pdf = Pdf::loadView('books.pdf', compact('books'));
        return $pdf->download('data_buku.pdf');
    }
}