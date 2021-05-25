<?php

declare(strict_types=1);

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     tags={"Testing"},
 *     summary="Ping",
 *     description="Verifica se a aplicação está em pé",
 *     path="/ping",
 *     @OA\Response(
 *         response="200",
 *         description="Time",
 *     )
 * )
 */

/**
 * @OA\Get(
 *     tags={"Testing"},
 *     summary="Database",
 *     description="Verfica se está conectado ao banco de dados",
 *     path="/database",
 *     @OA\Response(
 *         response="200",
 *         description="Connected",
 *     )
 * )
 */
