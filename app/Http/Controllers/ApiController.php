<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;

class ApiController extends Controller
{
    public function createTag(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        $tag = Tag::create([
            'name' => $request->input('name'),
        ]);

        return response()->json($tag, 201);
    }

    public function editTag(Request $request, $tagId)
    {
        $request->validate([
            'name' => 'required|unique:tags',
        ]);

        $tag = Tag::findOrFail($tagId);
        $tag->update([
            'name' => $request->input('name'),
        ]);

        return response()->json($tag);
    }

    public function createArticle(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'tags' => 'array',
        ]);

        $article = Article::create([
            'title' => $request->input('title'),
        ]);

        if ($request->has('tags')) {
            $article->tags()->attach($request->input('tags'));
        }

        return response()->json($article, 201);
    }

    public function editArticle(Request $request, $articleId)
    {
        $request->validate([
            'title' => 'required',
            'tags' => 'array',
        ]);

        $article = Article::findOrFail($articleId);
        $article->update([
            'title' => $request->input('title'),
        ]);

        if ($request->has('tags')) {
            $article->tags()->sync($request->input('tags'));
        }

        return response()->json($article);
    }

    public function deleteArticle($articleId)
    {
        $article = Article::findOrFail($articleId);
        $article->tags()->detach(); 
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }

    public function getArticles(Request $request)
    {
        $tags = $request->input('tags', []);
        $articles = Article::with('tags');

        foreach ($tags as $tag) {
            $articles->whereHas('tags', function ($query) use ($tag) {
                $query->where('name', $tag);
            });
        }

        $articles = $articles->get();

        return response()->json(['articles' => $articles, 'tags' => Tag::all()]);
    }

    public function getArticleById($articleId)
    {
        $article = Article::with('tags')->findOrFail($articleId);

        return response()->json(['article' => $article, 'tags' => Tag::all()]);
    }
}
