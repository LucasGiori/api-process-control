<?php

namespace Infrastructure\Utils\File;

use Http\StatusHttp;
use Infrastructure\Domain\Exceptions\SqlFileNotExistsException;

abstract class AbstractBaseReadSqlFile
{
    private const FULL_PATH = "%s/../../../../%s/src/Domain/SQL/%s.SQL";

    public static function read(string $folder, string $fileName): string
    {
        $file = sprintf(
            self::FULL_PATH,
            __DIR__,
            $folder,
            $fileName
        );

        if (!file_exists($file)) {
            throw new SqlFileNotExistsException(
                message: sprintf(
                    "O arquivo (%s/%s) não foi encontrado! Diretório completo: (%s)",
                    $folder,
                    $fileName,
                    $file
                ),
                statusCode: StatusHttp::INTERNAL_SERVER_ERROR
            );
        }

        return file_get_contents($file);
    }
}
