<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AdminFilter
 * Protège les routes Back Office (administrateur)
 * Redirige vers /admin/login si l'utilisateur n'est pas administrateur
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in') || !session()->get('is_admin')) {
            return redirect()->to('/admin/login')->with('error', 'Accès administrateur requis');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien à faire après
    }
}
