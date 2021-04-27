import {Entity} from "./entity";
import {EntityType} from "../entity-component/entity-type";

export interface Account extends Entity {
  type: EntityType.role,
  name: string,
  mail: string,
  password?: string,
  enabled: boolean,
  roles: number[];
}
