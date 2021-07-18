#unfinished work
#need to first create lambda + IAM + method and then the PAI gw

provider "aws" {
  region = "eu-west-3"
}

resource "aws_api_gateway_rest_api" "TitoAPI" {
  name = "TitoAPI"
}

resource "aws_api_gateway_deployment" "Tito_API_Gw" {
  rest_api_id = aws_api_gateway_rest_api.TitoAPI.id
}

resource "aws_api_gateway_stage" "dev" {
  deployment_id = aws_api_gateway_deployment.Tito_API_Gw.id
  rest_api_id   = aws_api_gateway_rest_api.TitoAPI.id
  stage_name    = "dev"
}

