}

        return 'error';
    }

    /**
     * Render an exception into a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $e
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function render($request, Throwable $e)
    {
        $transformed = $this->getTransformed($e);

        $response = $e instanceof Responsable ? $e->toResponse($request) : null;

        if (!$response && ($e instanceof HttpResponseException)) {
            $response = $e->getResponse();
        }

        if (!$response instanceof SymfonyResponse) {
            try {
                $response = $this->getResponse($request, $e, $transformed);
            } catch (Throwable $e) {
                $this->report($e);

                $response = new Response('Internal server error.', 500, ['Content-Type' => 'text/plain']);
            }
        }

        return $this->toIlluminateResponse($response, $transformed);
    }

    /**
     * Map exception into an illuminate response.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Throwable                                 $e
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected function toIlluminateResponse($response, Throwable $e)
    {
        if (!$response instanceof Response) {
            if ($response instanceof SymfonyRedirectResponse) {
                $response = new RedirectResponse($response->getTargetUrl(), $response->getStatusCode(), $response->headers->all());
            } else {
                $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());
            }
        }

        return $response->withException($e);
    }

    /**
     * Get the approprate response object.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $transformed
     * @param \Throwable               $exception
     *
     * @return \Symfony\Component\HttpFou