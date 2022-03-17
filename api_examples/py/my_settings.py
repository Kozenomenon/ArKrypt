# Credit to Jslay: https://github.com/jslay88/ark_api_example/blob/master/app/settings.py

import os
import ctypes
from pathlib import Path
from typing import Optional, Union

from pydantic import BaseSettings


def secret_from_file(path: Union[str, Path]) -> Optional[str]:
    """Check if file exists, if so, read single line"""
    if not isinstance(path, Path):
        path = Path(path)
    if not path.is_file():
        return
    with open(path, 'r') as f:
        return f.readline().strip()


class Settings(BaseSettings):
    APP_NAME: str = os.getenv('APP_NAME', 'my_py_api')
    MOD_IDENTIFIER: str = os.getenv('MOD_IDENTIFIER', 'my_py_api')
    SECRETS_DIR: str = os.getenv('SECRETS_DIR', f'/var/run/secrets/{APP_NAME}')
    CHACHA20_KEY: str = secret_from_file(Path(SECRETS_DIR) / MOD_IDENTIFIER / 'chacha20/key') or \
        os.getenv('CHACHA20_KEY','MEe5PTFa/8tKguOxto91gaYixTiVEY3nowCKhQdlrNk=')#'AAECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8=')
    # the initial block counter will default to 1. this should be an unsigned 32-bit integer. 
    CHACHA20_INIT_COUNTER: ctypes.c_uint32 = ctypes.c_uint32(secret_from_file(Path(SECRETS_DIR) / MOD_IDENTIFIER / 'chacha20/init-counter') or \
        os.getenv('CHACHA20_INIT_COUNTER',0x00000001))#0x00000001))
    LOG_LEVEL: str = os.getenv('LOG_LEVEL', 'INFO')
    if LOG_LEVEL not in ['DEBUG', 'INFO', 'WARNING', 'CRITICAL']:
        LOG_LEVEL = 'INFO'

    VERSION = '1.0.0'


settings = Settings()