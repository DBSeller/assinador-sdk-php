<?php

use Dbseller\AssinadorSdkPhp\Validation;

it("VALID CPF", function () {
    $validate = Validation::cpf("51286297087");
    expect($validate)->toBeTrue();
});

it("INVALID CPF", function () {
    $validate = Validation::cpf("123456789125");
    expect($validate)->toBeFalse();
});

it("VALID CNPJ", function () {
    $validate = Validation::cnpj("55714296000102");
    expect($validate)->toBeTrue();
});

it("INVALID CNPJ", function () {
    $validate = Validation::cnpj("55714296000100");
    expect($validate)->toBeFalse();
});

it("VALID FILE PDF", function () {
    $validate = Validation::isPDF("tmp/doc-modelo.pdf");
    expect($validate)->toBeTrue();
});

it("INVALID FILE PDF", function () {
    $validate = Validation::isPDF("tmp/oliveira-13570394760.pfx");
    expect($validate)->toBeFalse();
});


it("VALID FILE PFX", function () {
    $validate = Validation::isPFX("tmp/oliveira-13570394760.pfx");
    expect($validate)->toBeTrue();
});

it("INVALID FILE PFX", function () {
    $validate = Validation::isPFX("tmp/doc-modelo.pdf");
    expect($validate)->toBeFalse();
});

it("VALID BASE64", function () {
    $validate = Validation::isValid64base("iVBORw0KGgoAAAANSUhEUgAAAFAAAABQCAYAAACOEfKtAAAACXBIWXMAAAsTAAALEwEAmpwYAAAClElEQVR4nO2ZTYoTQRiGHxdjto4/JwiC3mGGLPQKs9SlV3A1rhxx6wVm4S2EEdTBG/gDegIHdKHCgKAlgWpswrSdqq8qVZ16H6hFOp3K10+66/26A0IIIcSWMvNDRLAPvAc+A3djJmiVXeAZ8BtwfvwBngM3ShdXM5eA+8CZl3YOPPLj3G878/ss9xU95sCL3hn3Grgd8H6z7AAPe2fYV+DBf86wA+CL3/cX8LTlkNn3IRG6xq2ukc2FzDXg2EtbCvgILCLamIX/bPcDHPu5t5qDgEtwnTZmdQn4NrIETJZ5QAjEtDFbGzKzgDbE2sYMfX7WQkjME7Yxkw+Z3YADyNnG7EWm/ORCwmVsYyYTMnPDJfYp8hILOcOqDZmdwncSpb+/aEjcSljLpEImZ0hYqT5krAVez11grSFjDYk7bJ4qQib3Iu0SjVL1j7Lu046bwEnvgE78tjFyC+zX93LN+i56WhRN94VDj5suA4cr96r3AtaQMQHW98fulQ/9MVzEInD+4AL3gHfGkNikwJhGPovAKwlDwhUQGNIlJBeYepF1BQWuEzLJBK7G/KtEdxKusMCxO6VkAldDIhWuEoFDIZNMYDeuJiq2RoH9Nia0TRpk+eEPmQqtVWB/3q4Pjqb7TyF3oS5zIx1bV/efTrIJWxOYjFyF1ooEGpFAIxJoRAKNSKARCWxFoFMfaEMCC5/Zzd+JOAm0IYFGJNCIBBqRQCMSaEQCjUigEQk0IoEbFPgE+AkcVVZXmQkj5v3h9/1eWV1lJoyY98hLfFxZXWUm9GgNNNKcwNPetrcJXqcSWFtdg4W+6W07TfA6lcDa6hosNDWutUs4NU4CbUigEQk00pzA1kYySh+Im7pAIYQQQgghBP/4C90BbMGgN+jZAAAAAElFTkSuQmCC");
    expect($validate)->toBeTrue();
});

it("INVALID BASE64", function () {
    $validate = Validation::isValid64base("aJwiC3mGGLPQKs9SlV3A1rhxx6wVm4S2EEdTBG/gDegIHdKHCgKAlgWpswrSdqq8qVZ16H6hFOp3K10+66/26A0IIIcSWMvNDRLAPvAc+A3djJmiVXeAZ8BtwfvwBngM3ShdXM5eA+8CZl3YOPPLj3G878/ss9xU95sCL3hn3Grgd8H6z7AAPe2fYV+DBf86wA+CL3/cX8LTlkNn3IRG6xq2ukc2FzDXg2EtbCvgILCLamIX/bPcDHPu5t5qDgEtwnTZmdQn4NrIETJZ5QAjEtDFbGzKzgDbE2sYMfX7WQkjME7Yxkw+Z3YADyNnG7EWm/ORCwmVsYyYTMnPDJfYp8hILOcOqDZmdwncSpb+/aEjcSljLpEImZ0hYqT5krAVez11grSFjDYk7bJ4qQib3Iu0SjVL1j7Lu046bwEnvgE78tjFyC+zX93LN+i56WhRN94VDj5suA4cr96r3AtaQMQHW98fulQ/9MVzEInD+4AL3gHfGkNikwJhGPovAKwlDwhUQGNIlJBeYepF1BQWuEzLJBK7G/KtEdxKusMCxO6VkAldDIhWuEoFDIZNMYDeuJiq2RoH9Nia0TRpk+eEPmQqtVWB/3q4Pjqb7TyF3oS5zIx1bV/efTrIJWxOYjFyF1ooEGpFAIxJoRAKNSKARCWxFoFMfaEMCC5/Zzd+JOAm0IYFGJNCIBBqRQCMSaEQCjUigEQk0IoEbFPgE+AkcVVZXmQkj5v3h9/1eWV1lJoyY98hLfFxZXWUm9GgNNNKcwNPetrcJXqcSWFtdg4W+6W07TfA6lcDa6hosNDWutUs4NU4CbUigEQk00pzA1kYySh+Im7pAIYQQQgghBP/4C90BbMGgN+jZAAAAAElFTkSuQmCC");
    expect($validate)->toBeFalse();
});






