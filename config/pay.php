<?php 
return [
		'alipay' => [
				'app_id'         => '2016091600528363',
				'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxmvX28i96T/Q64r6ZA8T1TruCUwSHM4eLqZvFWlilDeoDRVEZsWqQInuplJNQf4lCqRD208Laj9khSjTlTMF6rV1V4jmms6CYn7lt4TFLgJqRDI/uGzF41rAuJVPxCFxy0rf+gqY7V+gobagcvlOXl1udqNNA147DFDc9i0ANlCH0TUZoUdv1mCuClQqpB4I4cBgHIewPkgszZ2JjBUZrhEwZIttyMXm/baZW3R2wm6QDo52z0rFWYfyU6Jx2/sjDD202BAdeGSk3LuBJOcwJ7LcigT9KJpUUjqalf9uCf9a5rnxzLqDDgmSnmAF1dqKJYJimUHEf6oh5YCJnzMjJQIDAQAB',
				'private_key'    => 'MIIEpAIBAAKCAQEAowyMywYDBtBJK0mJJJt/paWRXkHyCMZ+bJtFx4WR77LSacgHK0LIGua/ordcPiApgKPqLLs4orBryQOwARhQBiUclD7ZiK10AvOEhzXQIfKeZ+H2VYnJlAhEWGg/W7L7YiudHxLJRELbPmTxtWlsNsye85SdzDqmWCi00QPgIAOU+jqBHwZvrKLw4oDyKB6yHa7OPV96hyQqqJuVl7+xomekyxpJD2aBhv8wqcU5TXbjgCQZWZoBpSujQ+geVtJPsyIqc8rxnYzSPodZLWl7RE6DAwkQQmB1jd8jglUJovr79AuXF8X+lHV7gVULyB/seZzuKy+zbmMfCm28dYA4MQIDAQABAoIBAQCYNO/92qfapXeYhDYVSV/Yx32zqwYBcSK1yiFSx3rbc2h/PS6MEPRyQHQmttrSV/3GS74gccnF/cEwzlNwQjz5740FSsKRl7JTyvYtrmuUNUPwn/zwDwdxPGJo0TBMLwICu8oaJtRh97NpRJxrCHXvlgbQRi0kaJ++bomVEPQZjSDVB84NqtheTmanUWBx9rDcidUSI7dy6qktsB1sluc8Dv2VVmmBN87ZQl8IT+66sXhY4JD72jtDos0spS83fMcXEtGPdZYxp5/yltCcm9AA7zsAchYPvXkaksFuKB6CqEl73sWh9Gwp5ej9sJ3qnHtFXJH40XhU3F8xjWdfJ0lRAoGBANLK3NCTfqcGzZDgHJ0sLf4Pk/6VBDhhj4TKC6wrcEL91RBCO4cNmFhX5A5EgY88fKlYguQgI8Y/l6Odeigq7TKvHf1l9DiWHSLlsFw2sU6MakGWdDRydqk6Axxj6XxhkXMXMj+leATNOBhAd5JyaoRIr/7nQle5avE0WNst+XNFAoGBAMYEblF49/kD3xZY/BG3wiTO4QvsDrW9R16HAXKj+6B+Bkkld/85CeS9IieV6axseT/7dpo9RM8f+UzznlJghL9Vw5LsUy+vr2HXhlg/8PNoxW3Vwc9bFelEWS0UmND4Fs/RT7i3Cs1moy/yBxcDEpUcnFhVxrKSA4xGdv4xCmn9AoGBAMJrx7U9hWDLHolUnC+/kwA1IBx9F3JlUbl5ncCEJDw14PHpFPyg5nX9QuSB/Tm+4YBUmg2NM1HkT5niYsxvo23PJQsWoWYb1u3cColTDMDVNCAghDfnp1i4oCvsX2uQllYf/AHGPee33NhJhb/2dhZi8KlcZc2BwIiO7rHiOqU9AoGAUqC4s/CJcPRnm7in/nCyZ4+YItRu0vFXnZ8yQHci4baUwuMKropLkZJGdUQ+DL/63HL+65+TXeaWrcCemPtDiV+tS1qn36csxOQdYCfWUIuwjoN66x60BvGJUKFenxxW0IMkBA0FSe6BO9l/kd+rWmNk7gtk7VC2gEtLDgjCsrUCgYBA6n2ZiLnoJsal7bhBcdFywog76+RcGTsy9zYrcaDTb6pv9qDWwirXccnYUrdOg6Rpj1JmMTEskm2/u/buqeuHxr6kHw2y4RERGlbbtZUnjXTg8wfKc418LY7nhHqd/38rMeL1ThEHv77mm97FbTMc0crC6Uvb0Cqz0FR8wTABpQ==',
				'log'            => [
						'file' => storage_path('logs/alipay.log'),
				],
		],

		'wechat' => [
				'app_id'      => '',
				'mch_id'      => '',
				'key'         => '',
				'cert_client' => '',
				'cert_key'    => '',
				'log'         => [
						'file' => storage_path('logs/wechat_pay.log'),
				],
		],
];