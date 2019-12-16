<?php


namespace App\Controllers\Villes;

use App\Controllers\Controller;
use Slim\Http\Response;
use App\Models\Ville;

class VilleController extends Controller
{
     /**
     * @apiGroup Departements
     * @apiName index
     * @api {get} /departements
     * @apiSuccess {String[]}   departements        Tableau JSON
     * @apiSuccess {String}     ville.departement   Le département de la ville
     * @apiDescription Liste tous les départements de France
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * [
     * { departement: "AIN" },
     * { departement: "AISNE" },
     * ...
     * ]
     */

     /**
     * @param Response $response
     * @return Response
     */
    public function departements(Response $response): Response
    {
        $result = $this->cache->remember("departements", 10, function () {
            return Ville::distinct()->get(['departement'])->toJson();
        });
        return $response->write($result)->withHeader('Content-Type','application/json')->withStatus(200);
    }


     /**
     * @apiGroup Communes
     * @apiName index
     * @api {get} /villes/{departement}
     * @apiSuccess (200) {String[]} villes Tableau JSON
     * @apiSuccess (200) {String} ville.nom Le nom de la ville
     * @apiSuccess (200) {String} ville.codepostal Le code postal
     * @apiSuccess (200) {String} ville.departement Le département
     * @apiSuccess (200) {String} ville.INSEE Le n°INSEE
     * @apiDescription Liste des communes liées au département passé en paramètre.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * [
     * {
     *     "nom": "AIGALIERS",
     *     "codepostal": "30700",
     *     "departement": "GARD",
     *     "INSEE": "30001\r"
     * },
     * {
     *     "nom": "AIGREMONT",
     *     "codepostal": "30350",
     *     "departement": "GARD",
     *     "INSEE": "30002\r"
     * },
     * ...
     * ]
     */

     /**
     * @param Response $response
     * @param string $departement
     * @return Response
     */
    public function communes(Response $response, string $departement): Response
    {
        $result = $this->cache->remember("communes:{$departement}", 10, function () use ($departement) {
           $data = ['data' => Ville::where('departement', $departement)->get()];
           return json_encode($data);
        });
        return $response->write($result)->withHeader('Content-Type','application/json')->withStatus(200);
    }
}